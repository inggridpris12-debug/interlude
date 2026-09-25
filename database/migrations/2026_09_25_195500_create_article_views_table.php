<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_views', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('article_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('view_count')->default(0);
            $table->timestamp('last_viewed_at')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'article_id']);
            $table->index(['user_id', 'last_viewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_views');
    }
};
