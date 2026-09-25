<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | THREADS
        |--------------------------------------------------------------------------
        | Migration ini dibuat adaptif:
        | - kalau threads belum ada -> buat versi final
        | - kalau versi lama sudah ada -> tambahkan kolom body
        */

        if (! Schema::hasTable('threads')) {
            Schema::create('threads', function (Blueprint $table) {
                $table->id();

                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->text('body');

                $table->string('topic', 80)
                    ->nullable();

                $table->string('visibility', 20)
                    ->default('public');

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

            /*
             * Jika sebelumnya memakai thread_parts, ambil bagian pertama
             * sebagai body utama supaya data lama tidak langsung hilang.
             */
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

        /*
        |--------------------------------------------------------------------------
        | THREAD LIKES
        |--------------------------------------------------------------------------
        */
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

                $table->unique([
                    'thread_id',
                    'user_id',
                ]);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | THREAD BOOKMARKS
        |--------------------------------------------------------------------------
        */
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

                $table->unique([
                    'thread_id',
                    'user_id',
                ]);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | THREAD REPLIES / COMMENTS
        |--------------------------------------------------------------------------
        | parent_id membuat komentar dapat dibalas seperti Twitter.
        */
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
    }

    public function down(): void
    {
        /*
         * Sengaja tidak drop tabel agar rollback migration ini
         * tidak menghapus data utas user secara tidak sengaja.
         */
    }
};
