<?php

use Illuminate\Database\Seeder;
use App\Konsumen;

class KonsumenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Konsumen::create([
            'nama'          => 'Gugik',
            'tanggal_lahir' => '1993-07-29',
            'alamat'        => 'Jl Blimbing',
            'telepon'       => '08182312371',
            'hp'            => '0818238127272',
            'nama_cp'       => 'Adek Gugik',
            'telepon_cp'    => '08182312371',
            'nama_restoran' => 'Gugik Restoran',
            'telepon_restoran' => '08182312371',
        ]);
        Konsumen::create([
            'nama'          => 'Hendro',
            'tanggal_lahir' => '1993-08-29',
            'alamat'        => 'Jl Amerika',
            'telepon'       => '08182312371',
            'hp'            => '0818238127272',
            'nama_cp'       => 'Adek Hendro',
            'telepon_cp'    => '08182312371',
            'nama_restoran' => 'Hendro Restoran',
            'telepon_restoran' => '08182312371',
        ]);
    }
}
