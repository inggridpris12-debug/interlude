<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\ThreadPoll;
use App\Models\ThreadReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ThreadController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:280'],
            'topic' => ['nullable', 'string', 'max:80'],
            'visibility' => ['required', 'in:public,followers'],

            'images' => ['nullable', 'array', 'max:4'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],

            'video' => ['nullable', 'file', 'mimes:mp4,webm,mov', 'max:51200'],
            'audio' => ['nullable', 'file', 'mimes:mp3,m4a,wav,ogg', 'max:20480'],

            'files' => ['nullable', 'array', 'max:4'],
            'files.*' => [
                'file',
                'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt',
                'max:20480',
            ],

            'link' => ['nullable', 'url', 'max:1000'],

            'poll_question' => ['nullable', 'string', 'max:180'],
            'poll_options' => ['nullable', 'array', 'max:4'],
            'poll_options.*' => ['nullable', 'string', 'max:100'],
        ], [
            'body.required' => 'Tulis utasanmu terlebih dahulu.',
            'body.max' => 'Utas maksimal 280 karakter.',
            'images.max' => 'Maksimal 4 gambar.',
        ]);

        DB::transaction(function () use ($request, $validated) {
            $thread = Thread::create([
                'user_id' => Auth::id(),
                'body' => trim($validated['body']),
                'topic' => $validated['topic'] ?: null,
                'visibility' => $validated['visibility'],
            ]);

            $this->storeUploadedAttachments(
                owner: $thread,
                request: $request,
                prefix: ''
            );

            if (! empty($validated['link'])) {
                $thread->attachments()->create([
                    'type' => 'link',
                    'path' => null,
                    'original_name' => null,
                    'mime_type' => null,
                    'file_size' => null,
                    'metadata' => ['url' => $validated['link']],
                    'position' => 90,
                ]);
            }

            $question = trim(
                (string) ($validated['poll_question'] ?? '')
            );

            $options = collect(
                $validated['poll_options'] ?? []
            )
                ->map(fn ($option) => trim((string) $option))
                ->filter()
                ->values();

            if ($question !== '' && $options->count() >= 2) {
                $poll = $thread->poll()->create([
                    'question' => $question,
                ]);

                foreach ($options->take(4) as $index => $option) {
                    $poll->options()->create([
                        'label' => $option,
                        'position' => $index + 1,
                    ]);
                }
            }
        });

        return redirect()
            ->route('dashboard', ['feed' => 'utas'])
            ->with('success', 'Utas berhasil diposting.');
    }

    public function show(Thread $thread)
    {
        $user = Auth::user();
        $followingIds = $user->following()->pluck('users.id');

        $isVisible =
            $thread->visibility === 'public'
            || $thread->user_id === $user->id
            || (
                $thread->visibility === 'followers'
                && $followingIds->contains($thread->user_id)
            );

        abort_unless($isVisible, 403);

        $thread->load([
            'user',
            'attachments',
            'poll.options.votes',
            'poll.votes',
            'topLevelReplies.user',
            'topLevelReplies.attachments',
            'topLevelReplies.childrenRecursive',
        ])->loadCount([
            'likes',
            'replies',
        ]);

        return view('threads.show', compact('thread'));
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

    public function reply(Request $request, Thread $thread)
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:280'],
            'parent_id' => ['nullable', 'integer', 'exists:thread_replies,id'],

            'reply_images' => ['nullable', 'array', 'max:4'],
            'reply_images.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'reply_video' => ['nullable', 'file', 'mimes:mp4,webm,mov', 'max:51200'],
            'reply_audio' => ['nullable', 'file', 'mimes:mp3,m4a,wav,ogg', 'max:20480'],

            'reply_files' => ['nullable', 'array', 'max:4'],
            'reply_files.*' => [
                'file',
                'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt',
                'max:20480',
            ],

            'reply_link' => ['nullable', 'url', 'max:1000'],
        ]);

        $parentId = $validated['parent_id'] ?? null;

        if ($parentId) {
            $parent = ThreadReply::query()
                ->where('id', $parentId)
                ->where('thread_id', $thread->id)
                ->firstOrFail();

            $parentId = $parent->id;
        }

        DB::transaction(function () use (
            $request,
            $thread,
            $validated,
            $parentId
        ) {
            $reply = $thread->replies()->create([
                'user_id' => Auth::id(),
                'parent_id' => $parentId,
                'body' => trim($validated['body']),
            ]);

            $this->storeUploadedAttachments(
                owner: $reply,
                request: $request,
                prefix: 'reply_'
            );

            if (! empty($validated['reply_link'])) {
                $reply->attachments()->create([
                    'type' => 'link',
                    'path' => null,
                    'original_name' => null,
                    'mime_type' => null,
                    'file_size' => null,
                    'metadata' => ['url' => $validated['reply_link']],
                    'position' => 90,
                ]);
            }
        });

        return redirect()
            ->route('threads.show', $thread)
            ->with(
                'success',
                $parentId
                    ? 'Balasan berhasil dikirim.'
                    : 'Komentar berhasil dikirim.'
            );
    }

    public function vote(
        Request $request,
        Thread $thread,
        ThreadPoll $poll
    ) {
        abort_unless(
            $poll->thread_id === $thread->id,
            404
        );

        $validated = $request->validate([
            'option_id' => ['required', 'integer'],
        ]);

        $option = $poll->options()
            ->where('id', $validated['option_id'])
            ->firstOrFail();

        $poll->votes()->updateOrCreate(
            ['user_id' => Auth::id()],
            ['thread_poll_option_id' => $option->id]
        );

        return back()->with(
            'success',
            'Pilihan polling tersimpan.'
        );
    }

    public function destroy(Thread $thread)
    {
        abort_unless(
            $thread->user_id === Auth::id(),
            403
        );

        $this->deleteOwnerFiles($thread);

        foreach ($thread->replies as $reply) {
            $this->deleteOwnerFiles($reply);
        }

        $thread->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Utas berhasil dihapus.');
    }

    private function storeUploadedAttachments(
        $owner,
        Request $request,
        string $prefix = ''
    ): void {
        $position = 1;

        foreach ($request->file($prefix.'images', []) as $image) {
            $path = $image->store('threads/images', 'public');

            $owner->attachments()->create([
                'type' => 'image',
                'path' => $path,
                'original_name' => $image->getClientOriginalName(),
                'mime_type' => $image->getMimeType(),
                'file_size' => $image->getSize(),
                'metadata' => null,
                'position' => $position++,
            ]);
        }

        if ($video = $request->file($prefix.'video')) {
            $path = $video->store('threads/videos', 'public');

            $owner->attachments()->create([
                'type' => 'video',
                'path' => $path,
                'original_name' => $video->getClientOriginalName(),
                'mime_type' => $video->getMimeType(),
                'file_size' => $video->getSize(),
                'metadata' => null,
                'position' => $position++,
            ]);
        }

        if ($audio = $request->file($prefix.'audio')) {
            $path = $audio->store('threads/audio', 'public');

            $owner->attachments()->create([
                'type' => 'audio',
                'path' => $path,
                'original_name' => $audio->getClientOriginalName(),
                'mime_type' => $audio->getMimeType(),
                'file_size' => $audio->getSize(),
                'metadata' => null,
                'position' => $position++,
            ]);
        }

        foreach ($request->file($prefix.'files', []) as $file) {
            $path = $file->store('threads/files', 'public');

            $owner->attachments()->create([
                'type' => 'file',
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'metadata' => null,
                'position' => $position++,
            ]);
        }
    }

    private function deleteOwnerFiles($owner): void
    {
        foreach ($owner->attachments as $attachment) {
            if (
                $attachment->path
                && Storage::disk('public')->exists(
                    $attachment->path
                )
            ) {
                Storage::disk('public')->delete(
                    $attachment->path
                );
            }
        }
    }
}
