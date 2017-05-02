<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jenis;
use Carbon\Carbon;

class LaporanInventoryController extends Controller
{
    public function stok(Request $request)
    {
        $jenis = Jenis::get()
            ->transform(function ($item) {
                $item->jumlah = $item->inventory->sum('jumlah_aktual');
                return $item;
            });

        $data = compact('jenis');
        return view('app.inventory_index', $data);
    }

    public function harian(Request $request)
    {
        $start = $request->input('start') ? new Carbon($request->input('start')) : Carbon::yesterday();
        $end = $request->input('end') ? new Carbon($request->input('end')) : Carbon::today();

        $jenis = Jenis::get();
        $times = collect();
        for ($time = new Carbon($start); !$time->gt($end); $time = $time->addDay()) {
            $timestring = $time->toDateString();
            $times->push($timestring);
        }

        foreach ($jenis as $item) {
            /* perulangan tiap hari */
            $jumlah[$item->id] = array();
            foreach ($times as $timestring) {
                $jumlah[$item->id][$timestring] = $item->inventory()
                    ->where('tanggal_masuk', '<', $timestring)
                    ->sum('jumlah');
                $jumlah[$item->id][$timestring] -= $item->transaksi()
                    ->whereHas('nota', function($q) use ($time) {
                        return $q->where('tanggal', '<', $time);
                    })
                    ->sum('jumlah');
            }
        }
        $data = compact('jenis', 'start', 'end', 'times', 'jumlah');
        return view('app.inventory_harian', $data);
    }
}
