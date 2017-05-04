<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\File;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $file = File::paginate(4);
        return view('file.index',compact('file'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $file = new TbFile;
        return view('file.create',compact('file'))->renderSections()['content'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'nama' => 'required',
            'file' => 'required|mimes:jpg'
        ]);
        $maxId = \DB::table('file')->max('id') + 1;
        try{       
            $uploaded = $request->file('file');
            $file = new File;
            $file->id = $maxId;
            $file->nama = $request->nama;
            $file->file = $maxId."-".$uploaded->getClientOriginalName();
            $file->save();
            $uploaded->move(public_path('images/'),$file->file);
            \Session::flash('flash_message','Gambar berhasil ditambahkan');
        }catch(\Exception $e){
            echo $e->getMessage();
            echo "<br>".$e->getLine();
            die();
        }
        $response = array(
            'status' => 'success',
            'url' => action('FileController@index'),
        );
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $file = File::findOrFail($id);
        unlink(public_path('images/').$file->file);
        $file->delete();
        \Session::flash('flash_message','Dokumen berhasil di hapus');
        return redirect()->action('FileController@index');
    }
}
