<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 30)->nullable()->unique()->after('name');
            $table->string('profile_photo')->nullable()->after('password');
            $table->string('profile_avatar_preset', 40)->nullable()->after('profile_photo');
            $table->string('cover_image')->nullable()->after('profile_avatar_preset');
            $table->string('cover_preset', 40)->nullable()->after('cover_image');
            $table->string('university')->nullable()->after('cover_preset');
            $table->string('major')->nullable()->after('university');
            $table->string('location')->nullable()->after('major');
            $table->text('bio')->nullable()->after('location');
            $table->boolean('show_likes_on_profile')->default(true)->after('bio');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn([
                'username',
                'profile_photo',
                'profile_avatar_preset',
                'cover_image',
                'cover_preset',
                'university',
                'major',
                'location',
                'bio',
                'show_likes_on_profile',
            ]);
        });
    }
};
