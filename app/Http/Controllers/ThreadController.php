<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\ThreadReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'body' => [
                'required',
                'string',
                'max:280',
            ],
            'topic' => [
                'nullable',
                'string',
                'max:80',
            ],
            'visibility' => [
                'required',
                'in:public,followers',
            ],
        ], [
            'body.required' => 'Tulis utasanmu terlebih dahulu.',
            'body.max' => 'Utasan maksimal 280 karakter.',
        ]);

        Thread::create([
            'user_id' => Auth::id(),
            'body' => trim($validated['body']),
            'topic' => $validated['topic'] ?: null,
            'visibility' => $validated['visibility'],
        ]);

        return redirect()
            ->route('dashboard', ['feed' => 'utas'])
            ->with('success', 'Utasan berhasil diposting.');
    }

    public function like(Thread $thread)
    {
        $user = Auth::user();

        $existing = $thread
            ->likes()
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            $thread->likes()->create([
                'user_id' => $user->id,
            ]);
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'count' => $thread->likes()->count(),
        ]);
    }

    public function bookmark(Thread $thread)
    {
        $user = Auth::user();

        $existing = $thread
            ->bookmarks()
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $bookmarked = false;
        } else {
            $thread->bookmarks()->create([
                'user_id' => $user->id,
            ]);
            $bookmarked = true;
        }

        return response()->json([
            'success' => true,
            'bookmarked' => $bookmarked,
        ]);
    }

    public function reply(
        Request $request,
        Thread $thread
    ) {
        $validated = $request->validate([
            'body' => [
                'required',
                'string',
                'max:280',
            ],
            'parent_id' => [
                'nullable',
                'integer',
                'exists:thread_replies,id',
            ],
        ]);

        $parentId = $validated['parent_id'] ?? null;

        if ($parentId) {
            $parent = ThreadReply::query()
                ->where('id', $parentId)
                ->where('thread_id', $thread->id)
                ->firstOrFail();

            $parentId = $parent->id;
        }

        $thread->replies()->create([
            'user_id' => Auth::id(),
            'parent_id' => $parentId,
            'body' => trim($validated['body']),
        ]);

        return back()->with(
            'success',
            $parentId
                ? 'Balasan komentar berhasil dikirim.'
                : 'Komentar berhasil dikirim.'
        );
    }

    public function destroy(Thread $thread)
    {
        abort_unless(
            $thread->user_id === Auth::id(),
            403
        );

        $thread->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Utasan berhasil dihapus.');
    }
}
