<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:teacher,student'],
        ])->validate();

        // Validasi jika role teacher harus pakai email sekolah
        if ($input['role'] === 'teacher' && !str_ends_with($input['email'], '@school.sch.id')) {
            throw ValidationException::withMessages([
                'email' => ['Only school email can register as teacher.'],
            ]);
        }

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // Berikan role sesuai input
        $user->assignRole($input['role']);

        return $user;
    }
}
