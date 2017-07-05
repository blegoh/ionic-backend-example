<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Collection;
use JWTAuth;

class DecisionController extends Controller
{
    private $user;
    private $labels;

    public function __construct()
    {
        $this->middleware('jwt.auth');
        $this->user = JWTAuth::parseToken()->authenticate();
        $this->labels = new Collection();
    }

    public function index()
    {
        $hasils = new Collection();
        $lahans = User::find($this->user->id)->lahans;
        foreach ($lahans as $lahan) {
            $value = $this->getTinggiTempatScore($lahan->tinggi_tempat) + $this->getSuhuScore($lahan->suhu) +
                $this->getCurahHujanScore($lahan->curah_hujan) + $this->getBulanKeringScore($lahan->jumlah_bulan_kering) +
                $this->getPHScore($lahan->ph) + $this->getBOScore($lahan->bo) +
                $this->getKedalamanScore($lahan->kedalaman) + $this->getKemiringanScore($lahan->kemiringan);
            $hasils->push($value);
        }
        return $hasils->toJson();
    }

    public function labels()
    {
        $lahans = User::find($this->user->id)->lahans;
        foreach ($lahans as $lahan) {
            $this->labels->push($lahan->name);
        }
        return $this->labels->toJson();
    }

    private function getTinggiTempatScore($tinggiTempat)
    {
        $prioritySubSub = 0;
        $prioritySub = 0.158928571;
        $priority = 0.0833333333;
        if ($tinggiTempat > 2500){
            $prioritySubSub = 0.353983041;
        }elseif ($tinggiTempat >= 1500){
            $prioritySubSub = 0.2678693411;
        }elseif ($tinggiTempat >= 600){
            $prioritySubSub = 0.0564663057;
        }elseif ($tinggiTempat >= 400){
            $prioritySubSub = 0.1133929401;
        }else{
            $prioritySubSub = 0.2082883721;
        }
        $score = $prioritySubSub * $tinggiTempat + $prioritySub * $tinggiTempat + $priority * $tinggiTempat;
        return $score;
    }

    private function getSuhuScore($suhu)
    {
        $prioritySubSub = 0;
        $prioritySub = 0.2803571429;
        $priority = 0.0833333333;
        if ($suhu < 6.2){
            $prioritySubSub = 0.3791100191;
        }elseif ($suhu <= 11){
            $prioritySubSub = 0.2301610702;
        }elseif ($suhu <= 17){
            $prioritySubSub = 0.072123942;
        }elseif ($suhu <= 21){
            $prioritySubSub = 0.143999454;
        }else{
            $prioritySubSub = 0.1746055146;
        }
        $score = $prioritySubSub * $suhu + $prioritySub * $suhu + $priority * $suhu;
        return $score;
    }

    private function getCurahHujanScore($curahHujan)
    {
        $prioritySubSub = 0;
        $prioritySub = 0.3160714286;
        $priority = 0.0833333333;
        if ($curahHujan < 910){
            $prioritySubSub = 0.3311668725;
        }elseif ($curahHujan <= 3640){
            $prioritySubSub = 0.1707619177;
        }elseif ($curahHujan <= 9100){
            $prioritySubSub = 0.10786599;
        }elseif ($curahHujan <= 18200){
            $prioritySubSub = 0.135435806;
        }else{
            $prioritySubSub = 0.2547694137;
        }
        $score = $prioritySubSub * $curahHujan + $prioritySub * $curahHujan + $priority * $curahHujan;
        return $score;
    }

    private function getBulanKeringScore($bulanKering)
    {
        $prioritySubSub = 0;
        $prioritySub = 0.2446428572;
        $priority = 0.0833333333;
        if ($bulanKering < 1){
            $prioritySubSub = 0.2718163063;
        }elseif ($bulanKering == 1){
            $prioritySubSub = 0.2412239102;
        }elseif ($bulanKering <= 3){
            $prioritySubSub = 0.1538113228;
        }elseif ($bulanKering <= 6){
            $prioritySubSub = 0.0849663746;
        }else{
            $prioritySubSub = 0.2481820861;
        }
        $score = $prioritySubSub * $bulanKering + $prioritySub * $bulanKering + $priority * $bulanKering;
        return $score;
    }

    private function getPHScore($ph)
    {
        $prioritySubSub = 0;
        $prioritySub = 0.3250000001;
        $priority = 0.9166666667;
        if ($ph < 4){
            $prioritySubSub = 0.3529301675;
        }elseif ($ph < 7){
            $prioritySubSub = 0.0717162972;
        }elseif ($ph == 7){
            $prioritySubSub = 0.1062643754;
        }elseif ($ph <= 9){
            $prioritySubSub = 0.1805605842;
        }else{
            $prioritySubSub = 0.2885285758;
        }
        $score = $prioritySubSub * $ph + $prioritySub * $ph + $priority * $ph;
        return $score;
    }

    private function getBOScore($bo)
    {
        $prioritySubSub = 0;
        $prioritySub = 0.1916666664;
        $priority = 0.9166666667;
        if ($bo > 4){
            $prioritySubSub = 0.2790251897;
        }elseif ($bo > 3){
            $prioritySubSub = 0.1582162022;
        }elseif ($bo == 3){
            $prioritySubSub = 0.0550730823;
        }elseif ($bo > 1){
            $prioritySubSub = 0.139599875;
        }else{
            $prioritySubSub = 0.3680856508;
        }
        $score = $prioritySubSub * $bo + $prioritySub * $bo + $priority * $bo;
        return $score;
    }

    private function getKedalamanScore($kedalaman)
    {
        $prioritySubSub = 0;
        $prioritySub = 0.2416666667;
        $priority = 0.9166666667;
        if ($kedalaman > 90){
            $prioritySubSub = 0.0509172659;
        }elseif ($kedalaman > 60){
            $prioritySubSub = 0.086604817;
        }elseif ($kedalaman > 15){
            $prioritySubSub = 0.125276724;
        }elseif ($kedalaman > 10){
            $prioritySubSub = 0.2694216046;
        }else{
            $prioritySubSub = 0.4677795885;
        }
        $score = $prioritySubSub * $kedalaman + $prioritySub * $kedalaman + $priority * $kedalaman;
        return $score;
    }

    private function getKemiringanScore($kemiringan)
    {
        $prioritySubSub = 0;
        $prioritySub = 0.2416666667;
        $priority = 0.9166666667;
        if ($kemiringan < 9){
            $prioritySubSub = 0.3502380952;
        }elseif ($kemiringan < 16){
            $prioritySubSub = 0.1927380952;
        }elseif ($kemiringan < 26){
            $prioritySubSub = 0.1554761905;
        }elseif ($kemiringan < 46){
            $prioritySubSub = 0.0997619048;
        }else{
            $prioritySubSub = 0.2017857143;
        }
        $score = $prioritySubSub * $kemiringan + $prioritySub * $kemiringan + $priority * $kemiringan;
        return $score;
    }
}
