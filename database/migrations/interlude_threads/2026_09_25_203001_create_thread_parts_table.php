<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thread_parts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('thread_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->text('body');
            $table->unsignedTinyInteger('position');

            $table->timestamps();

            $table->unique([
                'thread_id',
                'position',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thread_parts');
    }
};
