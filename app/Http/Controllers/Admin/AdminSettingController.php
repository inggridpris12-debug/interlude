<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminSettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan platform & akun kurator.
     */
    public function edit()
    {
        $groups = $this->groups();
        $values = Setting::values();

        return view('admin.settings', compact('groups', 'values'));
    }

    /**
     * Simpan pengaturan platform.
     */
    public function update(Request $request)
    {
        $groups = $this->groups();

        $rules = [];

        foreach ($groups as $group) {
            foreach ($group['fields'] as $key => $field) {
                $rules[$key] = $field['rules'];
            }
        }

        $request->validate($rules);

        foreach ($groups as $group) {
            $payload = [];

            foreach ($group['fields'] as $key => $field) {
                if (($field['type'] ?? 'text') === 'boolean') {
                    $payload[$key] = $request->boolean($key) ? '1' : '0';
                } else {
                    $payload[$key] = $request->input($key);
                }
            }

            Setting::setMany($payload, $group['key']);
        }

        return back()->with('success', 'Pengaturan platform berhasil disimpan.');
    }

    /**
     * Perbarui identitas akun kurator yang sedang login.
     */
    public function updateAccount(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150', Rule::unique('admins', 'email')->ignore($admin->id)],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];

        // Kolom password memakai cast `hashed`, jadi cukup kirim nilai mentah.
        if (! empty($validated['password'])) {
            $admin->password = $validated['password'];
        }

        $admin->save();

        return back()->with('success', 'Profil kurator berhasil diperbarui.');
    }

    /**
     * Skema pengaturan yang tersedia di panel kurator.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function groups(): array
    {
        return [
            [
                'key' => 'identitas',
                'title' => 'Identitas Situs',
                'description' => 'Nama, tagline, dan deskripsi singkat platform yang tampil di panel kurator.',
                'icon' => 'fa-solid fa-globe',
                'fields' => [
                    'site_name' => [
                        'label' => 'Nama Situs',
                        'type' => 'text',
                        'default' => 'Interlude',
                        'help' => 'Dipakai sebagai judul tab dan brand panel kurator.',
                        'rules' => ['required', 'string', 'max:80'],
                    ],
                    'site_tagline' => [
                        'label' => 'Tagline',
                        'type' => 'text',
                        'default' => 'Ruang Tukar Cerita Mahasiswa',
                        'help' => 'Satu baris singkat yang menggambarkan platform.',
                        'rules' => ['nullable', 'string', 'max:120'],
                    ],
                    'site_description' => [
                        'label' => 'Deskripsi Singkat',
                        'type' => 'textarea',
                        'default' => 'Interlude menghubungkan cerita, riset, dan podcast mahasiswa lintas kampus.',
                        'help' => 'Maksimal 300 karakter.',
                        'rules' => ['nullable', 'string', 'max:300'],
                    ],
                    'contact_email' => [
                        'label' => 'Email Kontak',
                        'type' => 'email',
                        'default' => 'halo@interlude.id',
                        'help' => 'Alamat surel resmi untuk aduan dan kerja sama.',
                        'rules' => ['nullable', 'email', 'max:150'],
                    ],
                ],
            ],
            [
                'key' => 'moderasi',
                'title' => 'Moderasi & Publikasi',
                'description' => 'Atur kebijakan pendaftaran, kuota kurasi, serta batas unggahan konten mahasiswa.',
                'icon' => 'fa-solid fa-shield-halved',
                'fields' => [
                    'registration_open' => [
                        'label' => 'Pendaftaran Mahasiswa Dibuka',
                        'type' => 'boolean',
                        'default' => '1',
                        'help' => 'Jika dimatikan, akun baru tidak bisa mendaftar.',
                        'rules' => ['nullable', 'boolean'],
                    ],
                    'featured_limit' => [
                        'label' => 'Batas Artikel Pilihan',
                        'type' => 'number',
                        'default' => '6',
                        'help' => 'Jumlah maksimal artikel kurasi yang tampil di beranda.',
                        'rules' => ['nullable', 'integer', 'min:1', 'max:24'],
                    ],
                    'podcast_upload_max_mb' => [
                        'label' => 'Batas Unggah Podcast (MB)',
                        'type' => 'number',
                        'default' => '200',
                        'help' => 'Ukuran maksimal berkas audio/video podcast.',
                        'rules' => ['nullable', 'integer', 'min:1', 'max:500'],
                    ],
                ],
            ],
        ];
    }
}
