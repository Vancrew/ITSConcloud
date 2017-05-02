<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

use App\Inventory;
use App\ItemTransaksi;
use App\Jenis;
use App\JenisOperasional;
use App\Konsumen;
use App\Modal;
use App\Nota;
use App\Pembayaran;
use App\Produsen;
use App\RiwayatOperasional;
use Excel;

class LaporanTransaksiController extends Controller
{
    /**
     * Ini fungsi buat ngefilter data sebelum di "get". filternya pake range
     * jadi ada parameter $start dan $end. Kalau filternya kosong, brarti ga
     * perlu difilter
     *
     * @param QueryBuilder
     * @param String date start
     * @param String date end
     * @param String date field on model
     *
     * @return QueryBuilder
     */
    private function filterDateRange($model, $start, $end, $tanggal = 'tanggal')
    {
        if ($start && $end) {
            return $model->where($tanggal, '>=', $start)->where($tanggal, '<=', $end);
        } else {
            return $model;
        }
    }

    /**
     * List transaksi pembelian.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPembelian(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $modal = $this->filterDateRange(Modal::select('*'), $start, $end)->get();

        if (!$start) {
            $start = date('Y-m-d');
        }
        if (!$end) {
            $end = date('Y-m-d');
        }
        $data = compact('modal', 'start', 'end');
        return view('app.laporan_pembelian_list', $data);
    }

    /**
     * Detail transaksi pembelian.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPembelian($id)
    {
        $modal = Modal::find($id);

        $data = compact('modal');
        return view('app.laporan_pembelian_show', $data);
    }

    /**
     * List transaksi penjualan.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPenjualan(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $nota = $this->filterDateRange(Nota::select('*'), $start, $end)->get();

        if (!$start) {
            $start = date('Y-m-d');
        }
        if (!$end) {
            $end = date('Y-m-d');
        }
        $data = compact('nota', 'start', 'end');
        return view('app.laporan_penjualan_list', $data);
    }

    /**
     * Detail transaksi penjualan.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPenjualan($id)
    {
        $nota = Nota::find($id);
        $nota->tanggal = date('Y-m-d', strtotime($nota->tanggal));

        $data = compact('nota');
        return view('app.laporan_penjualan_show', $data);
    }

    /**
     * Ngeluarin kuitansi penjualan dalam excel.
     *
     * @return \Illuminate\Http\Response
     */
    public function excelPenjualan($id)
    {
        $nota = Nota::find($id);
        Excel::create('Filename', function($excel) use($nota) {
            $excel->sheet('Sheetname', function($sheet) use($nota) {
                $items = $nota->item_transaksi
                    ->map(function($item, $key) {
                        $item->nama = $item->jenis->nama;
                        $item->no = $key + 1;
                        return collect($item->toArray())
                            ->only(['no', 'nama', 'biaya'])
                            ->reverse();
                    });
                // dd($items);
                $sheet->fromArray($items, null, 'A3');
            });
        })->export('xls');
    }

}
