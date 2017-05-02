<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengeluaranLainnya extends Model
{
    protected $table = 'pengeluaran_lainnya';

    public function jenis_operasional()
    {
        return $this->belongsTo('App\JenisOperasional');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
