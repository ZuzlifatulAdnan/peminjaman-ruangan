<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Custom validation for fullname, status, and other fields
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string'],
            'no_whatsapp' => ['required', 'string'],
            // Optional: Add validation for NPM/NIP based on status
            'npm' => $input['role'] === 'Mahasiswa' ? ['required', 'string'] : ['nullable'],
            'nip' => $input['role'] === 'Dosen' ? ['required', 'string'] : ['nullable'],
        ])->validate();

        // Create the new user with custom fields
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $input['role'],
            'no_whatsapp' => $input['no_whatsapp'],
            'npm' => $input['npm'] ?? null, // If status is 'Mahasiswa', assign npm
            'nip' => $input['nip'] ?? null, // If status is 'Dosen', assign nip
        ]);
    }
}
