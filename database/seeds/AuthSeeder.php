<?php

use Illuminate\Database\Seeder;
use \App\User;
class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        return User::create([
            'nama' => 'Admin Sripuja',
            'username' => 'test',
            'email' => 'fwpvt99@gmail.com',
            'password' => Hash::make('test'),
            'hak_akses' => 1
        ]);

    }
}
