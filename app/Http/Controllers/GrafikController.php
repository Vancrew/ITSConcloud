<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\Jenis;
use App\JenisOperasional;
use App\Nota;
use App\Pembayaran;
use App\PengeluaranLainnya;
use App\RiwayatOperasional;

class GrafikController extends Controller
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

    public function keuntunganBersih(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $nota = $this->filterDateRange(Nota::select('*'), $start, $end)->get();
        $notal = $nota
            ->map(function ($item) {
                $item->tanggal = date('j M Y', strtotime($item->tanggal));
                return $item;
            })
            ->groupBy('tanggal')
            ->transform(function ($item) {
                return [
                    'keuntungan_bersih' => $item->sum('keuntungan_bersih'),
                ];
            });

        $keuntungan_bersih = $notal->pluck('keuntungan_bersih');
        $tanggal = $notal->keys();

        if (!$start) {
            $start = date('Y-m-d');
        }
        if (!$end) {
            $end = date('Y-m-d');
        }
        $data = compact('keuntungan_bersih', 'tanggal', 'start', 'end');
        return view('app.grafik.keuntungan_bersih', $data);
    }

    public function modalAktual(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $nota = $this->filterDateRange(Nota::select('*'), $start, $end)->get();
        $notal = $nota
            ->map(function ($item) {
                $item->tanggal = date('j M Y', strtotime($item->tanggal));
                return $item;
            })
            ->groupBy('tanggal')
            ->transform(function ($item) {
                return [
                    'modal_bersih' => $item->sum('total_modal'),
                    'modal_aktual' => $item->sum('total_pembayaran'),
                ];
            });

        $modal_bersih = $notal->pluck('modal_bersih');
        $modal_aktual = $notal->pluck('modal_aktual');
        $tanggal = $notal->keys();

        if (!$start) {
            $start = date('Y-m-d');
        }
        if (!$end) {
            $end = date('Y-m-d');
        }
        $data = compact('modal_bersih', 'modal_aktual', 'tanggal', 'start', 'end');
        return view('app.grafik.modal_aktual', $data);
    }

    /**
     * Nampilin pie chart buat seberapa persen pengeluaran yang sudah balik
     * modal.
     */
    public function freshMoney(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $inventory = $this->filterDateRange(Inventory::select('*'), $start, $end)->get();
        $invent = $inventory
            ->map(function ($item) {
                $item->tanggal = date('j M Y', strtotime($item->tanggal_masuk));
                return $item;
            })
            ->groupBy('tanggal')
            ->transform(function ($item) {
                $item->transform(function ($inv) {
                    $sisa = $inv->jumlah_aktual * $inv->harga_beli;
                    $jual = ($inv->jumlah - $inv->jumlah_aktual) * $inv->harga_beli;
                    return compact('sisa', 'jual');
                });
                return [
                    'sisa' => $item->sum('sisa'),
                    'jual' => $item->sum('jual'),
                ];
            });
        $sisa = $invent->sum('sisa');
        $jual = $invent->sum('jual');
        $tanggal = $invent->keys();

        if (!$start) {
            $start = date('Y-m-d');
        }
        if (!$end) {
            $end = date('Y-m-d');
        }
        $data = compact('sisa', 'jual', 'tanggal', 'start', 'end');
        // dd($data);
        return view('app.grafik.fresh_money', $data);
    }

    /**
     * Nampilin line chart jumlah rupiah penjualan tiap tanggal.
     */
    public function penjualanBulanan(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $nota = $this->filterDateRange(Nota::select('*'), $start, $end)->get();
        $notal = $nota
            ->map(function ($item) {
                $item->tanggal = date('j M Y', strtotime($item->tanggal));
                return $item;
            })
            ->groupBy('tanggal')
            ->transform(function ($item) {
                return [
                    'total_harga' => $item->sum('total_harga'),
                ];
            });

        $total_harga = $notal->pluck('total_harga');
        $tanggal = $notal->keys();

        if (!$start) {
            $start = date('Y-m-d');
        }
        if (!$end) {
            $end = date('Y-m-d');
        }
        $data = compact('nota', 'total_harga', 'tanggal', 'start', 'end');
        return view('app.grafik.penjualan_bulanan', $data);
    }

    /**
     * Nampilin bar chart buat komposisi penjualan barang per kilo dalam
     * range waktu.
     */
    public function komposisiPenjualan(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $nota = $this->filterDateRange(Nota::select('*'), $start, $end)->get();
        $item = collect();
        $nota->each(function ($not) use(&$item) {
            $item = $item->merge($not->item_transaksi);
        });
        $byJenis = $item->groupBy('inventory_jenis')
            ->transform(function ($item, $key) { // item transaksi
                $jenis = Jenis::find($key);
                $jumlah = $item->sum('jumlah');
                return [
                    'jenis' => $jenis->nama,
                    'jumlah' => $jumlah
                ];
            })->values();

        $jenis = $byJenis->pluck('jenis');
        $jumlah = $byJenis->pluck('jumlah');

        if (!$start) {
            $start = date('Y-m-d');
        }
        if (!$end) {
            $end = date('Y-m-d');
        }
        $data = compact('jenis', 'jumlah', 'start', 'end');
        // dd($data);
        return view('app.grafik.komposisi_penjualan', $data);
    }

    /**
     * Nampilin bar chart buat komposisi biaya operasional transaksi
     * dalam range waktu.
     */
    public function komposisiOperasional(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $operasional = $this->filterDateRange(RiwayatOperasional::select('*'), $start, $end)->get()
            ->groupBy('jenis_operasional_id')
            ->transform(function ($item, $key) {
                $jenis = JenisOperasional::find($key);
                $jumlah = $item->sum('biaya');
                return [
                    'jenis' => $jenis->nama,
                    'jumlah' => $jumlah
                ];
            })->values();
        // dd($operasional);

        $jenis = $operasional->pluck('jenis');
        $jumlah = $operasional->pluck('jumlah');

        if (!$start) {
            $start = date('Y-m-d');
        }
        if (!$end) {
            $end = date('Y-m-d');
        }
        $data = compact('jenis', 'jumlah', 'start', 'end');
        // dd($data);
        return view('app.grafik.komposisi_operasional', $data);
    }

    /**
     * Nampilin bar chart buat komposisi biaya pengeluaran lainnya
     * dalam range waktu.
     */
    public function komposisiPengeluaran(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $operasional = $this->filterDateRange(PengeluaranLainnya::select('*'), $start, $end)->get()
            ->groupBy('jenis_operasional_id')
            ->transform(function ($item, $key) {
                $jenis = JenisOperasional::find($key);
                $jumlah = $item->sum('biaya');
                return [
                    'jenis' => $jenis->nama,
                    'jumlah' => $jumlah
                ];
            })->values();
        // dd($operasional);

        $jenis = $operasional->pluck('jenis');
        $jumlah = $operasional->pluck('jumlah');

        if (!$start) {
            $start = date('Y-m-d');
        }
        if (!$end) {
            $end = date('Y-m-d');
        }
        $data = compact('jenis', 'jumlah', 'start', 'end');
        // dd($data);
        return view('app.grafik.komposisi_pengeluaran', $data);
    }

    /**
     * Nampilin pie chart buat melihat perbandingan pemasukan dan 
     * pengeluaran.
     */
    public function pemasukanPengeluaran(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $pengeluaran = 0;
        $pemasukan = 0;

        $pengeluaran += $this->filterDateRange(RiwayatOperasional::select('*'), $start, $end)->get()->sum('biaya');
        $pengeluaran += $this->filterDateRange(PengeluaranLainnya::select('*'), $start, $end)->get()->sum('biaya');
        $pengeluaran += $this->filterDateRange(Inventory::select('*'), $start, $end)->get()->sum('harga_beli');

        $pemasukan += $this->filterDateRange(Pembayaran::select('*'), $start, $end)->get()->sum('biaya');

        if (!$start) {
            $start = date('Y-m-d');
        }
        if (!$end) {
            $end = date('Y-m-d');
        }
        $data = compact('pengeluaran', 'pemasukan', 'start', 'end');
        // dd($data);
        return view('app.grafik.pemasukan_pengeluaran', $data);
    }

    /**
     * Nampilin double bar chart buat bandingin jumlah barang yang dibeli
     * dan yang sudah terjual.
     */
    public function modalPenjualan(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $nota = $this->filterDateRange(Nota::select('*'), $start, $end)->get();
        $item = collect();
        $nota->each(function ($not) use(&$item) {
            $item = $item->merge($not->item_transaksi);
        });
        $byJenis = $item->groupBy('inventory_jenis')
            ->transform(function ($item, $key) { // item transaksi
                $jenis = Jenis::find($key);
                $jumlah = $item->sum('jumlah');
                $jumlah_modal = $jenis->inventory->sum('jumlah');
                return [
                    'jenis' => $jenis->nama,
                    'jumlah' => $jumlah,
                    'jumlah_modal' => $jumlah_modal,
                ];
            })->values();

        $jenis = $byJenis->pluck('jenis');
        $jumlah = $byJenis->pluck('jumlah');
        $jumlah_modal = $byJenis->pluck('jumlah_modal');

        if (!$start) {
            $start = date('Y-m-d');
        }
        if (!$end) {
            $end = date('Y-m-d');
        }
        $data = compact('jenis', 'jumlah', 'jumlah_modal', 'start', 'end');
        // dd($data);
        return view('app.grafik.modal_penjualan', $data);
    }

}
