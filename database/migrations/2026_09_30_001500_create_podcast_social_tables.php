<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('podcast_likes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('podcast_id')
                ->constrained('podcasts')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(
                ['podcast_id', 'user_id'],
                'podcast_likes_podcast_user_unique'
            );
        });

        Schema::create('podcast_bookmarks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('podcast_id')
                ->constrained('podcasts')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(
                ['podcast_id', 'user_id'],
                'podcast_bookmarks_podcast_user_unique'
            );
        });

        Schema::create('podcast_comments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('podcast_id')
                ->constrained('podcasts')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('podcast_comments')
                ->cascadeOnDelete();

            $table->text('body');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('podcast_comments');
        Schema::dropIfExists('podcast_bookmarks');
        Schema::dropIfExists('podcast_likes');
    }
};
