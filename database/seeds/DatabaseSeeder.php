<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(BarangTableSeeder::class);
        $this->call(OperasionalTableSeeder::class);
        $this->call(KonsumenTableSeeder::class);
        $this->call(ProdusenTableSeeder::class);
    }
}
