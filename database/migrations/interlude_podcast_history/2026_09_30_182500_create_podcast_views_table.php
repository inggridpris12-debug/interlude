<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('podcast_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('podcast_id')
                ->constrained('podcasts')
                ->cascadeOnDelete();
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamp('last_viewed_at')->nullable()->index();
            $table->timestamps();

            $table->unique(['user_id', 'podcast_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('podcast_views');
    }
};
