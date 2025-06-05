<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
         Role::firstOrCreate(['name' => 'teacher']);

        // Cek apakah user kepala jurusan sudah ada
        $existingUser = User::where('email', 'admin.rpl@email.com')->first();

        if ($existingUser) {
            // Jika user sudah ada, pastikan punya role teacher
            if (!$existingUser->hasRole('teacher')) {
                $existingUser->assignRole('teacher');
                echo "Role teacher berhasil di-assign ke user yang sudah ada\n";
            } else {
                echo "User kepala jurusan sudah ada dengan role teacher\n";
            }
        } else {
            // Buat user kepala jurusan baru
            $kajur = User::create([
                'name' => 'Kepala Jurusan RPL',
                'email' => 'admin.rpl@email.com',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
            ]);

            // Assign role teacher
            $kajur->assignRole('teacher');

            echo "Kepala Jurusan berhasil dibuat dengan email: admin.rpl@email.com\n";
    }
}
}
