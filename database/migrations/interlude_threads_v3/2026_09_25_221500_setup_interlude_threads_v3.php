<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('threads')) {
            Schema::create('threads', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();
                $table->text('body');
                $table->string('topic', 80)->nullable();
                $table->string('visibility', 20)->default('public');
                $table->timestamps();

                $table->index(['user_id', 'created_at']);
                $table->index(['visibility', 'created_at']);
                $table->index('topic');
            });
        } elseif (! Schema::hasColumn('threads', 'body')) {
            Schema::table('threads', function (Blueprint $table) {
                $table->text('body')
                    ->nullable()
                    ->after('user_id');
            });

            if (Schema::hasTable('thread_parts')) {
                $rows = DB::table('thread_parts')
                    ->where('position', 1)
                    ->get();

                foreach ($rows as $row) {
                    DB::table('threads')
                        ->where('id', $row->thread_id)
                        ->whereNull('body')
                        ->update([
                            'body' => $row->body,
                        ]);
                }
            }
        }

        if (! Schema::hasTable('thread_likes')) {
            Schema::create('thread_likes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('thread_id')
                    ->constrained()
                    ->cascadeOnDelete();
                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['thread_id', 'user_id']);
            });
        }

        if (! Schema::hasTable('thread_bookmarks')) {
            Schema::create('thread_bookmarks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('thread_id')
                    ->constrained()
                    ->cascadeOnDelete();
                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['thread_id', 'user_id']);
            });
        }

        if (! Schema::hasTable('thread_replies')) {
            Schema::create('thread_replies', function (Blueprint $table) {
                $table->id();
                $table->foreignId('thread_id')
                    ->constrained()
                    ->cascadeOnDelete();
                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();
                $table->foreignId('parent_id')
                    ->nullable()
                    ->constrained('thread_replies')
                    ->cascadeOnDelete();
                $table->text('body');
                $table->timestamps();

                $table->index([
                    'thread_id',
                    'parent_id',
                    'created_at',
                ]);
            });
        } elseif (! Schema::hasColumn('thread_replies', 'parent_id')) {
            Schema::table('thread_replies', function (Blueprint $table) {
                $table->foreignId('parent_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('thread_replies')
                    ->cascadeOnDelete();
            });
        }

        if (! Schema::hasTable('attachments')) {
            Schema::create('attachments', function (Blueprint $table) {
                $table->id();

                $table->string('attachable_type');
                $table->unsignedBigInteger('attachable_id');

                $table->string('type', 30);
                $table->string('path')->nullable();
                $table->string('original_name')->nullable();
                $table->string('mime_type')->nullable();
                $table->unsignedBigInteger('file_size')->nullable();
                $table->json('metadata')->nullable();
                $table->unsignedSmallInteger('position')->default(1);

                $table->timestamps();

                $table->index([
                    'attachable_type',
                    'attachable_id',
                ]);

                $table->index([
                    'attachable_type',
                    'attachable_id',
                    'position',
                ], 'attachments_owner_position_idx');
            });
        }

        if (! Schema::hasTable('thread_polls')) {
            Schema::create('thread_polls', function (Blueprint $table) {
                $table->id();
                $table->foreignId('thread_id')
                    ->unique()
                    ->constrained()
                    ->cascadeOnDelete();
                $table->string('question', 180);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('thread_poll_options')) {
            Schema::create('thread_poll_options', function (Blueprint $table) {
                $table->id();
                $table->foreignId('thread_poll_id')
                    ->constrained()
                    ->cascadeOnDelete();
                $table->string('label', 100);
                $table->unsignedTinyInteger('position');
                $table->timestamps();

                $table->unique([
                    'thread_poll_id',
                    'position',
                ]);
            });
        }

        if (! Schema::hasTable('thread_poll_votes')) {
            Schema::create('thread_poll_votes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('thread_poll_id')
                    ->constrained()
                    ->cascadeOnDelete();
                $table->foreignId('thread_poll_option_id')
                    ->constrained()
                    ->cascadeOnDelete();
                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();
                $table->timestamps();

                $table->unique([
                    'thread_poll_id',
                    'user_id',
                ]);
            });
        }
    }

    public function down(): void
    {
        // Sengaja tidak drop otomatis agar rollback tidak menghapus data user.
    }
};
