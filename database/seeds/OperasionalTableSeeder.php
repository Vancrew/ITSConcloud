<?php

use Illuminate\Database\Seeder;
use App\JenisOperasional;

class OperasionalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisOperasional::create(['nama' => 'Kuli']);
        JenisOperasional::create(['nama' => 'Karung']);
        JenisOperasional::create(['nama' => 'Transportasi']);
        JenisOperasional::create(['nama' => 'Makanan']);
    }
}
