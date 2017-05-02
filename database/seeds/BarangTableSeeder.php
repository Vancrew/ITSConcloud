<?php

use Illuminate\Database\Seeder;
use App\Jenis;

class BarangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jenis::create(['nama' => 'Beras Pandan Wangi', 'harga' => 20000]);
        Jenis::create(['nama' => 'Beras Lokal', 'harga' => 10000]);
        Jenis::create(['nama' => 'Beras Impor Jepang', 'harga' => 22500]);
        Jenis::create(['nama' => 'Beras Wangi', 'harga' => 18000]);
        Jenis::create(['nama' => 'Beras Wangi SDK', 'harga' => 18000]);
    }
}
