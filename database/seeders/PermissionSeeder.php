<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'lihat-dashboard',
            'lihat-laporan',
            'cetak-laporan',
            'lihat-pengajuan',
            'verifikasi-pengajuan',
            'cetak-pengajuan',
            'lihat-warga',
            'lihat-master-surat',
            'tambah-jenis-surat',
            'edit-jenis-surat',
            'hapus-jenis-surat',
            'manajemen-user',
            'persetujuan-kades'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
