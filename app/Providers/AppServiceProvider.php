<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Jenis;
use App\Konsumen;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Jenis::created(function ($jenis) {
            foreach (Konsumen::select('id')->get() as $konsumen) {
                $jenis->konsumen()->attach($konsumen->id, ['harga' => $jenis->harga]);
            }
        });

        Konsumen::created(function ($konsumen) {
            foreach (Jenis::select(['id', 'harga'])->get() as $jenis) {
                $jenis->konsumen()->attach($konsumen->id, ['harga' => $jenis->harga]);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__ . '/../Http/helpers.php';
    }
}
