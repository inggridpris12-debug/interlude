<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateDummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user
        $nadine = User::firstOrCreate(
            ['email' => 'nadine@interlude.id'],
            ['name' => 'Nadine', 'password' => Hash::make('password')]
        );

        $dimas = User::firstOrCreate(
            ['email' => 'dimas@interlude.id'],
            ['name' => 'Dimas Pratama', 'password' => Hash::make('password')]
        );

        $alya = User::firstOrCreate(
            ['email' => 'alya@interlude.id'],
            ['name' => 'Alya Putri', 'password' => Hash::make('password')]
        );

        // Hapus artikel lama jika ada
        Article::query()->delete();

        // Buat artikel
        Article::create([
            'user_id' => $nadine->id,
            'title' => 'Cara Menentukan Topik Penelitian Tanpa Overthinking',
            'excerpt' => 'Awalnya aku mengira menentukan topik penelitian harus langsung menemukan sesuatu yang besar. Ternyata, prosesnya justru dimulai dari pertanyaan sederhana.',
            'content' => 'Awalnya aku mengira menentukan topik penelitian harus langsung menemukan sesuatu yang besar. Ternyata, prosesnya justru dimulai dari pertanyaan sederhana.',
            'category' => 'Penelitian',
            'slug' => 'cara-menentukan-topik-penelitian-' . Str::random(6),
            'reading_time' => 6,
            'is_published' => true,
            'is_featured' => true,
            'published_at' => now()->subDays(5),
            'views_count' => 245,
        ]);

        Article::create([
            'user_id' => $dimas->id,
            'title' => 'Hal yang Aku Pelajari dari Organisasi Pertamaku',
            'excerpt' => 'Masuk organisasi ternyata bukan cuma soal menambah pengalaman, tetapi juga belajar bekerja dengan orang yang punya cara berpikir berbeda.',
            'content' => 'Masuk organisasi ternyata bukan cuma soal menambah pengalaman, tetapi juga belajar bekerja dengan orang yang punya cara berpikir berbeda.',
            'category' => 'Organisasi',
            'slug' => 'hal-yang-aku-pelajari-dari-organisasi-' . Str::random(6),
            'reading_time' => 5,
            'is_published' => true,
            'is_featured' => false,
            'published_at' => now()->subDays(3),
            'views_count' => 189,
        ]);

        Article::create([
            'user_id' => $alya->id,
            'title' => 'Minggu Pertamaku Magang',
            'excerpt' => 'Di minggu pertama, aku belajar bahwa dunia kerja tidak selalu berjalan seperti yang dibayangkan di kelas.',
            'content' => 'Di minggu pertama, aku belajar bahwa dunia kerja tidak selalu berjalan seperti yang dibayangkan di kelas.',
            'category' => 'Magang',
            'slug' => 'minggu-pertamaku-magang-' . Str::random(6),
            'reading_time' => 7,
            'is_published' => true,
            'is_featured' => false,
            'published_at' => now()->subDays(7),
            'views_count' => 312,
        ]);

        Article::create([
            'user_id' => $nadine->id,
            'title' => 'Cara Mengatur Waktu Saat Tugas Menumpuk',
            'excerpt' => 'Ketika semua tugas terasa penting, aku mulai membaginya berdasarkan energi dan waktu yang benar-benar aku punya.',
            'content' => 'Ketika semua tugas terasa penting, aku mulai membaginya berdasarkan energi dan waktu yang benar-benar aku punya.',
            'category' => 'Tips Belajar',
            'slug' => 'cara-mengatur-waktu-saat-tugas-' . Str::random(6),
            'reading_time' => 4,
            'is_published' => true,
            'is_featured' => false,
            'published_at' => now()->subDays(2),
            'views_count' => 156,
        ]);

        Article::create([
            'user_id' => $dimas->id,
            'title' => 'Pengalaman Mengikuti Organisasi Kampus',
            'excerpt' => 'Tiga tahun di organisasi kampus memberiku pelajaran yang tidak akan aku dapatkan di kelas manapun.',
            'content' => 'Tiga tahun di organisasi kampus memberiku pelajaran yang tidak akan aku dapatkan di kelas manapun.',
            'category' => 'Organisasi',
            'slug' => 'pengalaman-mengikuti-organisasi-' . Str::random(6),
            'reading_time' => 8,
            'is_published' => true,
            'is_featured' => false,
            'published_at' => now()->subDays(10),
            'views_count' => 278,
        ]);

        Article::create([
            'user_id' => $alya->id,
            'title' => 'Tips Memilih Tempat Magang',
            'excerpt' => 'Jangan hanya melihat nama perusahaan. Ada hal lain yang lebih penting untuk dipertimbangkan.',
            'content' => 'Jangan hanya melihat nama perusahaan. Ada hal lain yang lebih penting untuk dipertimbangkan.',
            'category' => 'Magang',
            'slug' => 'tips-memilih-tempat-magang-' . Str::random(6),
            'reading_time' => 5,
            'is_published' => true,
            'is_featured' => false,
            'published_at' => now()->subDays(15),
            'views_count' => 198,
        ]);

        Article::create([
            'user_id' => $nadine->id,
            'title' => 'Cara Bertahan di Semester 5',
            'excerpt' => 'Semester 5 adalah titik balik. Banyak yang merasa kehilangan arah. Ini cara aku melewatinya.',
            'content' => 'Semester 5 adalah titik balik. Banyak yang merasa kehilangan arah. Ini cara aku melewatinya.',
            'category' => 'Kehidupan Kampus',
            'slug' => 'cara-bertahan-di-semester-5-' . Str::random(6),
            'reading_time' => 6,
            'is_published' => true,
            'is_featured' => false,
            'published_at' => now()->subDays(20),
            'views_count' => 423,
        ]);

        Article::create([
            'user_id' => $dimas->id,
            'title' => 'Hal yang Ingin Aku Ketahui Sebelum Skripsi',
            'excerpt' => 'Seandainya ada yang memberitahuku ini di awal, mungkin proses skripsiku tidak akan selama ini.',
            'content' => 'Seandainya ada yang memberitahuku ini di awal, mungkin proses skripsiku tidak akan selama ini.',
            'category' => 'Tugas Kuliah',
            'slug' => 'hal-yang-ingin-aku-ketahui-sebelum-skripsi-' . Str::random(6),
            'reading_time' => 9,
            'is_published' => true,
            'is_featured' => false,
            'published_at' => now()->subDays(25),
            'views_count' => 367,
        ]);

        $this->command->info('✅ Berhasil membuat 8 artikel!');
    }
}