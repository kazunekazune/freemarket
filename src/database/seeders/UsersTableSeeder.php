<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'id' => 1,
            'name' => 'ダミーユーザー',
            'email' => 'dummy@example.com',
            'password' => Hash::make('password'), // パスワードは「password」
        ]);
    }
}
