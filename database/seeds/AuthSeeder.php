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
            'username' => 'sp_admin',
            'email' => 'fwpvt99@gmail.com',
            'password' => Hash::make('sripuja9914'),
            'hak_akses' => 1
        ]);

    }
}
