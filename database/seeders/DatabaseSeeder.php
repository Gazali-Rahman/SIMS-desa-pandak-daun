<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $wargaRole = Role::create(['name' => 'warga']);
        $staffRole = Role::create(['name' => 'staff']);
        $kadesRole = Role::create(['name' => 'kepala_desa']);

        // Create Admin/Staff User
        $staff = User::factory()->create([
            'name' => 'Admin Staff',
            'email' => 'admin@sims.com',
            'nik' => '1111222233334444',
            'password' => bcrypt('password'),
            'phone' => '081234567890',
            'address' => 'Kantor Desa Pandak Daun',
            'village' => 'Pandak Daun',
        ]);
        $staff->assignRole($staffRole);

        // Create Kades User
        $kades = User::factory()->create([
            'name' => 'Kepala Desa',
            'email' => 'kades@sims.com',
            'nik' => '5555666677778888',
            'password' => bcrypt('password'),
            'phone' => '081234567891',
            'address' => 'Kantor Desa Pandak Daun',
            'village' => 'Pandak Daun',
        ]);
        $kades->assignRole($kadesRole);

        // Create Dummy Warga
        $warga = User::factory()->create([
            'name' => 'Budi Warga',
            'email' => 'warga@sims.com',
            'nik' => '9999000011112222',
            'password' => bcrypt('password'),
            'phone' => '081234567892',
            'address' => 'Jl. Merdeka No 1',
            'rt' => '001',
            'rw' => '002',
            'village' => 'Pandak Daun',
        ]);
        $warga->assignRole($wargaRole);

        // Seed Permissions
        $this->call(PermissionSeeder::class);

        // Seed Jenis Surat
        $this->call(JenisSuratSeeder::class);
    }
}
