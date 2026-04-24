<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisSurat = [
            [
                'nama' => 'Surat Keterangan Domisili',
                'kode' => 'SKD',
                'deskripsi' => 'Surat keterangan domisili tempat tinggal saat ini.',
                'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                'syarat' => json_encode(['ktp' => true, 'kk' => true]),
                'is_active' => true,
            ],
            [
                'nama' => 'Surat Keterangan Tidak Mampu',
                'kode' => 'SKTM',
                'deskripsi' => 'Surat keterangan untuk keluarga kurang mampu.',
                'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'syarat' => json_encode(['ktp' => true, 'kk' => true]),
                'is_active' => true,
            ],
            [
                'nama' => 'Surat Pengantar SKCK',
                'kode' => 'SKCK',
                'deskripsi' => 'Pengantar pembuatan Surat Keterangan Catatan Kepolisian.',
                'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                'syarat' => json_encode(['ktp' => true, 'kk' => true]),
                'is_active' => true,
            ],
            [
                'nama' => 'Surat Keterangan Usaha',
                'kode' => 'SKU',
                'deskripsi' => 'Surat keterangan yang menyatakan bahwa yang bersangkutan memiliki usaha di desa ini.',
                'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                'syarat' => json_encode([
                    'ktp' => true,
                    'kk' => true,
                    'foto_usaha' => true,
                ]),
                'form_fields' => json_encode([
                    ['name' => 'nama_usaha', 'label' => 'Nama Usaha', 'type' => 'text'],
                    ['name' => 'jenis_usaha', 'label' => 'Jenis Usaha (Cth: Kuliner, Jasa)', 'type' => 'text'],
                    ['name' => 'tahun_berdiri', 'label' => 'Tahun Berdiri', 'type' => 'number'],
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($jenisSurat as $surat) {
            \App\Models\JenisSurat::create($surat);
        }
    }
}
