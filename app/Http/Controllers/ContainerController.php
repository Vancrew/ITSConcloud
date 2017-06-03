<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Container;

class ContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['images'] = apiGET('10.151.36.109:4243/images/json');
        foreach ($data['images'] as $image) {
            //dd($image->id_image);
            $json = apiGET('10.151.36.109:4243/images/'.$image->Id.'/json');
            $image->id_image = $image->Id;
            $image->Repo_tags = $json->RepoTags[0];
        }
        $data['container'] = Container::get();

        return view('app.container_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
        // dd($request->input('nama_image'));
        
        $jsontest = apiPOSTbody('10.151.36.109:4243/containers/create',$request->input('nama_image'));

        // berhasil
        // $jsontest = apiPOST('10.151.36.109:4243/containers/28b0ed731e3cb05e3e092c133fd12d71a4af4f2644b89f309c0eacb5c893c64a/start');
        // $json = apiPOST('10.151.36.109:4243/containers/'.$request->input('nama_image').'/start');
        // dd($jsontest);


        $container = new Container;
        $container->id_con = $jsontest->Id;
        $container->id_user = $request->input('id');
        // dd($container);
       
        $container->save();
        return redirect()->back()->with('tambah_success', true);

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
    }
}
