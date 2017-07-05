<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use JWTAuth;

class LahanController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->middleware('jwt.auth');
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::find($this->user->id)->lahans;
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
        $lahan = new Lahan();
        $lahan->name = $request->input('nama');
        $lahan->tinggi_tempat = $request->input('tinggi');
        $lahan->suhu = $request->input('suhu');
        $lahan->curah_hujan = $request->input('curah_hujan');
        $lahan->jumlah_bulan_kering = $request->input('bulan_kering');
        $lahan->ph = $request->input('ph');
        $lahan->bo = $request->input('bo');
        $lahan->kedalaman = $request->input('kedalaman');
        $lahan->kemiringan = $request->input('kemiringan');
        $lahan->user_id = $this->user->id;
        $lahan->save();
        return response()->json(['status' => 'ok'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lahan = Lahan::find($id);
	    return $lahan;
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
        $lahan = Lahan::find($id);
        $lahan->name = $request->input('name');
        $lahan->tinggi_tempat = $request->input('tinggi_tempat');
        $lahan->suhu = $request->input('suhu');
        $lahan->curah_hujan = $request->input('curah_hujan');
        $lahan->jumlah_bulan_kering = $request->input('jumlah_bulan_kering');
        $lahan->ph = $request->input('ph');
        $lahan->bo = $request->input('bo');
        $lahan->kedalaman = $request->input('kedalaman');
        $lahan->kemiringan = $request->input('kemiringan');
        $lahan->update();
        return response()->json(['status' => 'ok'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lahan::destroy($id);
        return response()->json(['status' => 'ok'], 200);
    }
}
