<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'user_type' => 'A',
            'password' => bcrypt('1234567890')
        ]);
        $user->assignRole('administrator');

    }
}
