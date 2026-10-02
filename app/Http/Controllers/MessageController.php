<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Notifications\InteractionNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $currentUser = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Ambil semua pesan milik user
        |--------------------------------------------------------------------------
        */

        $allMessages = Message::with(['sender', 'recipient'])
            ->where(function ($query) use ($currentUser) {
                $query
                    ->where('sender_id', $currentUser->id)
                    ->orWhere('recipient_id', $currentUser->id);
            })
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Cari semua partner percakapan
        |--------------------------------------------------------------------------
        */

        $partnerIds = $allMessages
            ->map(function ($message) use ($currentUser) {
                return $message->sender_id === $currentUser->id
                    ? $message->recipient_id
                    : $message->sender_id;
            })
            ->unique()
            ->values();

        $partners = User::whereIn('id', $partnerIds)
            ->get()
            ->keyBy('id');

        /*
        |--------------------------------------------------------------------------
        | Susun daftar percakapan
        |--------------------------------------------------------------------------
        */

        $conversations = $partnerIds
            ->map(function ($partnerId) use ($partners, $allMessages, $currentUser) {
                $partner = $partners->get($partnerId);

                if (! $partner) {
                    return null;
                }

                $conversationMessages = $allMessages->filter(function ($message) use ($partnerId, $currentUser) {
                    return (
                        $message->sender_id === $currentUser->id
                        && $message->recipient_id === $partnerId
                    ) || (
                        $message->sender_id === $partnerId
                        && $message->recipient_id === $currentUser->id
                    );
                });

                $lastMessage = $conversationMessages
                    ->sortByDesc('created_at')
                    ->first();

                $unreadCount = $conversationMessages
                    ->filter(function ($message) use ($partnerId, $currentUser) {
                        return $message->sender_id === $partnerId
                            && $message->recipient_id === $currentUser->id
                            && is_null($message->read_at);
                    })
                    ->count();

                return [
                    'user' => $partner,
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                ];
            })
            ->filter()
            ->sortByDesc(function ($conversation) {
                return $conversation['last_message']?->created_at;
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Tentukan chat yang sedang dibuka
        |--------------------------------------------------------------------------
        */

        $selectedUserId = (int) $request->query('user', 0);

        $activeUser = null;

        if (
            $selectedUserId > 0
            && $selectedUserId !== $currentUser->id
        ) {
            $activeUser = User::find($selectedUserId);
        }

        /*
         * Kalau URL tidak punya ?user=...
         * otomatis buka percakapan terakhir.
         */
        if (! $activeUser && $conversations->isNotEmpty()) {
            $activeUser = $conversations->first()['user'];
        }

        /*
        |--------------------------------------------------------------------------
        | Pesan di chat aktif
        |--------------------------------------------------------------------------
        */

        $conversationMessages = collect();

        if ($activeUser) {
            /*
             * Hanya tandai pesan dari orang yang sedang dibuka
             * sebagai sudah dibaca.
             */
            Message::where('sender_id', $activeUser->id)
                ->where('recipient_id', $currentUser->id)
                ->whereNull('read_at')
                ->update([
                    'read_at' => now(),
                ]);

            $conversationMessages = Message::with(['sender', 'recipient'])
                ->where(function ($query) use ($currentUser, $activeUser) {
                    $query
                        ->where('sender_id', $currentUser->id)
                        ->where('recipient_id', $activeUser->id);
                })
                ->orWhere(function ($query) use ($currentUser, $activeUser) {
                    $query
                        ->where('sender_id', $activeUser->id)
                        ->where('recipient_id', $currentUser->id);
                })
                ->oldest()
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Daftar mahasiswa untuk Pesan Baru
        |--------------------------------------------------------------------------
        */

        $users = User::whereKeyNot($currentUser->id)
            ->orderBy('name')
            ->get();

        return view('messages.index', compact(
            'conversations',
            'conversationMessages',
            'activeUser',
            'users'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'recipient_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'body' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        $recipient = User::findOrFail(
            $validated['recipient_id']
        );

        if ($recipient->id === $request->user()->id) {
            return back()
                ->withErrors([
                    'recipient_id' => 'Kamu tidak bisa mengirim pesan ke diri sendiri.',
                ])
                ->withInput();
        }

        Message::create([
            'sender_id' => $request->user()->id,
            'recipient_id' => $recipient->id,
            'body' => trim($validated['body']),
        ]);

        /*
         * Notifikasi menuju langsung ke percakapan pengirim.
         */
        $recipient->notify(
            new InteractionNotification(
                'message',
                $request->user()->name . ' mengirim pesan baru.',
                route('messages.index', [
                    'user' => $request->user()->id,
                ]),
            )
        );

        return redirect()
            ->route('messages.index', [
                'user' => $recipient->id,
            ])
            ->with('success', 'Pesan berhasil dikirim.');
    }
}