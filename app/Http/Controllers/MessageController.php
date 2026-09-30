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
        $user = $request->user();

        $messages = Message::with(['sender', 'recipient'])
            ->where(fn ($query) => $query
                ->where('sender_id', $user->id)
                ->orWhere('recipient_id', $user->id))
            ->latest()
            ->paginate(20);

        Message::where('recipient_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $users = User::whereKeyNot($user->id)->orderBy('name')->get();

        return view('messages.index', compact('messages', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'recipient_id' => ['required', 'integer', 'exists:users,id'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $recipient = User::findOrFail($validated['recipient_id']);

        if ($recipient->id === $request->user()->id) {
            return back()->withErrors(['recipient_id' => 'Kamu tidak bisa mengirim pesan ke diri sendiri.']);
        }

        Message::create([
            'sender_id' => $request->user()->id,
            'recipient_id' => $recipient->id,
            'body' => $validated['body'],
        ]);

        $recipient->notify(new InteractionNotification(
            'message',
            $request->user()->name.' mengirim pesan baru.',
            route('messages.index'),
        ));

        return redirect()->route('messages.index')->with('success', 'Pesan berhasil dikirim.');
    }
}
