<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BarangKonsumen;
use App\Jenis;
use App\Konsumen;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['jenis'] = Jenis::get();

        return view('app.jenis_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jenis = new Jenis;
        $jenis->nama = $request->input('nama');
        $jenis->harga = str_replace(',', '', $request->input('harga'));
        $jenis->save();

        return redirect()->back()->with('tambah_success', true);
    }

    /**
     * Nampilin kursnya barang.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['jenis'] = Jenis::find($id);

        return view('app.jenis_show', $data);
    }

    /**
     * Nampilin edit harga barang per konsumen.
     *
     * @param  int  $id jenis
     * @param  int  $id_konsumen
     * @return \Illuminate\Http\Response
     */
    public function getKonsumen($id, $konsumen_id)
    {
        $data['jenis'] = Jenis::find($id);
        $data['konsumen'] = Konsumen::find($konsumen_id);
        $data['barang_konsumen'] = BarangKonsumen::cari($id, $konsumen_id);

        return view('app.jenis_edit_konsumen', $data);
    }

    /**
     * Edit edit harga barang per konsumen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id jenis
     * @param  int  $id_konsumen
     * @return \Illuminate\Http\Response
     */
    public function postKonsumen(Request $request, $id, $konsumen_id)
    {
        $barang_konsumen = BarangKonsumen::cari($id, $konsumen_id);
        $barang_konsumen->harga = str_replace(',', '', $request->input('harga'));
        $barang_konsumen->save();
        return redirect('crud/jenis/'.$id)->with('edit_success', true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jenis = Jenis::find($id);
        $jenis->harga = str_replace(',', '', $request->input('harga'));
        $jenis->save();

        return redirect()->back()->with('edit_success', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jenis = Jenis::find(decrypt($id));
        $jenis->delete();
        return redirect()->back();
    }
}
