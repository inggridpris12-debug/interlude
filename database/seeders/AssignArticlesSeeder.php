<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignArticlesSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID user
        $nadine = DB::table('users')->where('email', 'nadine@interlude.id')->first();
        $dimas = DB::table('users')->where('email', 'dimas@interlude.id')->first();
        $alya = DB::table('users')->where('email', 'alya@interlude.id')->first();

        if (!$nadine || !$dimas || !$alya) {
            $this->command->error('User tidak ditemukan!');
            return;
        }

        // Update artikel berdasarkan kategori
        DB::table('articles')->where('category', 'Penelitian')->update(['user_id' => $nadine->id]);
        DB::table('articles')->where('category', 'Tips Belajar')->update(['user_id' => $nadine->id]);
        DB::table('articles')->where('category', 'Kehidupan Kampus')->update(['user_id' => $nadine->id]);
        
        DB::table('articles')->where('category', 'Organisasi')->update(['user_id' => $dimas->id]);
        DB::table('articles')->where('category', 'Tugas Kuliah')->update(['user_id' => $dimas->id]);
        
        DB::table('articles')->where('category', 'Magang')->update(['user_id' => $alya->id]);

        // Tampilkan hasil
        $this->command->info('✅ Artikel berhasil di-assign!');
        $this->command->info('');
        $this->command->info('Nadine: ' . DB::table('articles')->where('user_id', $nadine->id)->count() . ' artikel');
        $this->command->info('Dimas: ' . DB::table('articles')->where('user_id', $dimas->id)->count() . ' artikel');
        $this->command->info('Alya: ' . DB::table('articles')->where('user_id', $alya->id)->count() . ' artikel');
    }
}