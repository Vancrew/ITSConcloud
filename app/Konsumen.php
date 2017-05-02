<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Konsumen extends Model
{
    use SoftDeletes;

    protected $table = 'konsumen';

    protected $guarded = [];

    public function jenis()
    {
        return $this->belongsToMany('App\Jenis', 'barang_konsumens')
            ->withPivot('harga');
    }

    public function nota()
    {
        return $this->hasMany('App\Nota');
    }
}
