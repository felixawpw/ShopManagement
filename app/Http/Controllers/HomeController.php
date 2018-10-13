<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon, DB;

use App\Pegawai, App\Absen;
use App\Penjualan, App\Barang;
use App\Pembelian;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function getDialyReport($start, $end)
    {
        $penjualans = Penjualan::whereDate("tanggal", '>=', $start)->whereDate("tanggal", "<=", $end)->get();
        $profit = 0;
        $income = 0;
        $index = 0;
        foreach ($penjualans as $p)
        {
            $barangs = $p->barangs;
            foreach($barangs as $b)
            {
                $index++;
                $profit += ($b->pivot->hjual - $b->pivot->hbeli) * $b->pivot->quantity;
                $income += $b->pivot->hjual * $b->pivot->quantity;
            }
        }

        $barangs = Barang::whereHas('penjualans', function($q){
            $q->whereDate("tanggal", '=', Carbon::now()->toDateString());
        })->get();

        $categories = [];
        $brands = [];
        $showBarangs = [];
        $showCategories = [];
        $showBrands = [];
        foreach($barangs as $b)
        {
            $b->sum = $b->penjualans()->whereDate('penjualans.tanggal', '=', Carbon::now()->toDateString())->sum('barang_penjualan.quantity');

            $brandName = $b->brand->nama;
            $typeName = $b->product_type->nama;
            if (isset($brands["$brandName"]))
                $brands["$brandName"] += $b->sum;
            else
                $brands["$brandName"] = $b->sum;

            if (isset($categories["$typeName"]))
                $categories["$typeName"] += $b->sum;
            else
                $categories["$typeName"] = $b->sum;

            $showBarangs[] = ["nama" => $b->nama, "sum" => $b->sum];
        }

        foreach($categories as $key => $val)
        {
            $showCategories[] = ["nama" => $key, "sum" => $val];
        }

        foreach($brands as $key => $val)
        {
            $showBrands[] = ["nama" => $key, "sum" => $val];
        }

        $barangs->sortBy('sum');
        return ["profit" => $profit, 
            "income" => $income, 
            "barangs" => $showBarangs, 
            "categories" => $showCategories, 
            "brands" => $showBrands];
    }

    public function getHutang()
    {
        return Pembelian::where('status_pembayaran', '=', '0')->get();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dialyReport = $this->getDialyReport(Carbon::now()->toDateString(), Carbon::now()->toDateString());
        $hutangs = $this->getHutang();
        return view('home', compact("dialyReport", "hutangs"));
        // $pegawais = Pegawai::all();
        // $absens = Absen::where('absensi', '=', 0)->orderBy('pegawai_id', 'asc')->orderBy('tanggal', 'asc')->get();
        // /*
        // $events = array();
        // foreach($absens as $absen)
        // {
        //     $event = array();
        //     $event['title'] = $absen->pegawai->user->name;
        //     $event['start'] = $absen->tanggal;
        //     $events[] = $event;   
        // }
        // $events = json_encode($events);
        // */
        
        // $absenCounter = count($absens);
        // $count = 0;
        // $events = array();

        // if ($absenCounter > 0)
        // {        
        //     $prev = strtotime($absens[0]->tanggal);
        //     $tempevent = null;
        //     $prevId = $absens[0]->pegawai_id;
        //     foreach ($absens as $absen)
        //     {
        //         $idP = $absen->pegawai_id;
        //         $now = strtotime($absen->tanggal);
        //         if ($idP == $prevId)
        //         {
        //             if ($now - $prev == 86400)
        //                 $tempevent['end'] = date('Y-m-d', $now + 86400);
        //             else
        //             {
        //                 if (isset($tempevent))
        //                     $events[] = $tempevent;

        //                 $event = array();
        //                 $event['title'] = $absen->pegawai->user->name;
        //                 $event['start'] = explode(' ',$absen->tanggal)[0];
        //                 $tempevent = $event;
        //             }
        //         }
        //         else
        //         {
        //             if (isset($tempevent))
        //                 $events[] = $tempevent;

        //             $event = array();
        //             $event['title'] = $absen->pegawai->user->name;
        //             $event['start'] = explode(' ',$absen->tanggal)[0];
        //             $tempevent = $event;
        //         }
        //         $count++;
        //         if ($count < $absenCounter)
        //             $prev = $now;
        //         $prevId = $idP;
        //     }


        //     if ($now - $prev == 86400)
        //         $tempevent['end'] = date('Y-m-d', $now + 86400);
        //     $events[] = $tempevent;
        // }
        // $events = json_encode($events);     

        // return view('home', compact('pegawais', 'events'));
    }
}
