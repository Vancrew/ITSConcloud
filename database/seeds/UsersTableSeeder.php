<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->nama = 'Admin';
        $user->tanggal_lahir = date('Y-m-d');
        $user->alamat = 'Admin';
        $user->telepon = '0';
        $user->hp = '0';
        $user->tempat_lahir = 'Admin';
        $user->jabatan = 'admin';
        $user->username = 'admin';
        $user->password = bcrypt('admin');
        $user->save();
    }
}
