<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KursBarang extends Model
{
    protected $table = 'kurs_barang';

    public function modal()
    {
        return $this->belongsTo('App\Jenis');
    }
}
