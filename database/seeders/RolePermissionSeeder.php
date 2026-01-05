<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Buat Permissions (Hak Akses Spesifik)
        // Izin Umum
        Permission::create(['name' => 'view dashboard']);

        // Izin IMP (Organisasi Inti)
        Permission::create(['name' => 'manage imp']);   // Mengelola anggota/divisi

        // Izin AMPERA
        Permission::create(['name' => 'manage ampera']);    // Mengakses menu Ampera

        // Izin SI SEMAR
        Permission::create(['name' => 'manage sisemar']);   // Mengakses menu Si Semar

        // Izin Super Admin
        Permission::create(['name' => 'manage users']);     // Membuat user baru/ganti role

        // 3. Buat Roles & Assign Permissions

        // A. Admin AMPERA
        $roleAmpera = Role::create(['name' => 'admin-ampera']);
        $roleAmpera->givePermissionTo(['view dashboard', 'manage ampera']);

        // B. Admin SI SEMAR
        $roleSisemar = Role::create(['name' => 'admin-sisemar']);
        $roleSisemar->givePermissionTo(['view dashboard', 'manage sisemar']);

        // C. Admin IMP (Pengurus Harian)
        $roleImp = Role::create(['name' => 'admin-imp']);
        $roleImp->givePermissionTo(['view dashboard', 'manage imp']);

        // D. Super Admin (Bisa Semuanya)
        $roleSuperAdmin = Role::create(['name' => 'super-admin']);
        // Super admin punya semua permission yang ada
        $roleSuperAdmin->givePermissionTo(Permission::all());

        // E. Fungsio (Anggota Biasa)
        $roleFungsio = Role::create(['name' => 'fungsio']);
        $roleFungsio->givePermissionTo(['view dashboard']);

        // 4. Buat User Dummy untuk Tes (Opsional)

        // User Super Admin
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super@impunnes.web.id',
            'password' => bcrypt('impsuper26')
        ]);
        $user->assignRole($roleSuperAdmin);

        // User Admin IMP
        $user = User::factory()->create([
            'name' => 'Admin IMP',
            'email' => 'impgenk@impunnes.web.id',
            'password' => bcrypt('impgenk26')
        ]);
        $user->assignRole($roleImp);

        // User Admin AMPERA
        $user = User::factory()->create([
            'name' => 'Admin Ampera',
            'email' => 'ampera@impunnes.web.id',
            'password' => bcrypt('amperaimp26')
        ]);
        $user->assignRole($roleAmpera);

        // User Admin Si Semar
        $user = User::factory()->create([
            'name' => 'Admin Si Semar',
            'email' => 'sisemar@impunnes.web.id',
            'password' => bcrypt('sisemarimp26')
        ]);
        $user->assignRole($roleSisemar);
    }
}