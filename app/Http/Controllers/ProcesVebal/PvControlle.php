<?php

namespace App\Http\Controllers\ProcesVebal;

use App\Http\Controllers\Controller;
use App\Models\Pv;
use Illuminate\Http\Request;

class PvControlle extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
            'info' => 'required|min:10',
            ],[
                'info.required' => "L'info est obligatoire !",
                'info.min' => "L'info doit être au minimum 10 caractères"
            ]
        );
        $pv = new Pv();
        $pv->championnat_id = $request->championnat;
        $pv->message = $request->info;
        $pv->save();        

        return response()->json([
        'status' => "success"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $msgs = Pv::where('championnat_id',$id)->orderBy('id','DESC')->get();
        return response()->json([
            'pvs' => $msgs
        ]);
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
        $request->validate(
            [
            'message' => 'required|min:10',
            ],[
                'message.required' => "L'info est obligatoire !",
                'message.min' => "L'info doit être au minimum 10 caractères"
            ]
        );
    
        $info = Pv::find($id);
        $info->message = $request->message;
        $info->save();

        return response()->json([
        'status' => "success"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $in = Pv::find($id);
        $in->delete();
        return response()->json([
            'status'=>'success'
        ]);
    }
}
