<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAnonymousUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'ANONYMOUS',
            'password' => Hash::make('pass'),
            'email' => 'anonymous@gmail.com',
            'role_id' => 'ANONYMOUS'
        ]);
    }
}
