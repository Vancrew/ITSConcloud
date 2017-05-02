<?php

use Illuminate\Database\Seeder;
use App\Produsen;

class ProdusenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Produsen::create([
            'nama'          => 'Andre',
            'tanggal_lahir'  => '1993-07-29',
            'alamat'        => 'Jl Blimbing',
            'telepon'       => '08182312371',
            'hp'            => '0818238127272',
        ]);
        Produsen::create([
            'nama'          => 'Vinska',
            'tanggal_lahir'  => '1993-08-29',
            'alamat'        => 'Jl Amerika',
            'telepon'       => '08182312371',
            'hp'            => '0818238127272',
        ]);
    }
}
