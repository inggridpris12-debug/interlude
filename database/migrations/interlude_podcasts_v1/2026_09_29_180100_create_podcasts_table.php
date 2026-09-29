<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('podcast_series_id')->nullable()->constrained('podcast_series')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->enum('media_type', ['audio', 'video']);
            $table->string('cover_image')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->string('media_path')->nullable();
            $table->string('external_url')->nullable();
            $table->unsignedInteger('duration_seconds')->default(0);
            $table->unsignedInteger('episode_number')->nullable();
            $table->longText('transcript')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();

            $table->index(['is_published', 'published_at']);
            $table->index(['media_type', 'is_published']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('podcasts');
    }
};
