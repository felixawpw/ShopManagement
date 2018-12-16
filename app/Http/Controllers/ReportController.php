<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Penjualan, App\Pembelian, App\Barang;
use DB;
class ReportController extends Controller
{
    //
    public function showPenjualan() {
    	return view('report_penjualan.penjualan');
    }

    public function showPembelian() {
        return view('report_pembelian.pembelian');
    }

    public function showStok() {
        return view('report.stok');
    }



    public function generatePenjualan(Request $request) {
    	$tanggalAwal = Carbon::createFromFormat("m/d/Y", $request->input('awal'));
    	$tanggalAkhir = Carbon::createFromFormat("m/d/Y", $request->input('akhir'));
    	
        if ($tanggalAwal > $tanggalAkhir) 
    		return redirect()->back()->with("status", "0||Cetak laporan gagal||Pastikan tanggal akhir lebih besar dari tanggal awal!");

    	$tipe = $request->input('tipe');

        $formattedTanggalAwal = $tanggalAwal->format("D d M Y");
        $formattedTanggalAkhir = $tanggalAkhir->format("D d M Y");
        $penjualans = Penjualan::where("tanggal", ">=", $tanggalAwal->copy()->addDay(-1))->where("tanggal", "<=", $tanggalAkhir)->orderBy('tanggal', 'asc')->get();

    	switch ($tipe) {
    		case 'grafik':
                $temp = $tanggalAwal;
                $resultLaba = array();
                $resultOmset = array();
                $resultTipeBarang = array();
                $resultBrand = array();

                while ($temp < $tanggalAkhir) {
                    $penjualans = Penjualan::where("tanggal", "=", $temp->toDateString())->get();
                    $resultLaba[$temp->toDateString()] = 0;
                    $resultOmset[$temp->toDateString()] = 0;

                    foreach($penjualans as $p) {
                        $laba = 0;
                        $omset = 0;
                        $barangs = $p->barangs;
                        foreach ($barangs as $b) {
                            $laba += ($b->pivot->hjual - $b->pivot->hbeli) * $b->pivot->quantity;
                            $omset += $b->pivot->hjual * $b->pivot->quantity;

                            $resultTipeBarang[$b->product_type->nama] = (isset($resultTipeBarang[$b->product_type->name]) ? $resultTipeBarang[$b->product_type->name] : 0) + $b->pivot->quantity;
                            $resultBrand[$b->brand->nama] = (isset($resultBrand[$b->brand->name]) ? $resultBrand[$b->brand->name] : 0) + $b->pivot->quantity;
                        }
                        $resultLaba[$temp->toDateString()] = $laba;
                        $resultOmset[$temp->toDateString()] = $omset;
                    }

                    $temp->addDay(1);
                }

                return view('report_penjualan.penjualan_grafik', compact('resultLaba', 'resultOmset', 'resultTipeBarang', 'resultBrand', 'formattedTanggalAwal', 'formattedTanggalAkhir'));
    			break;
    		case 'printout':
                foreach ($penjualans as $p) {
                    $laba = 0;

                    $barangs = $p->barangs;
                    foreach($barangs as $b) {
                        $laba += ($b->pivot->hjual - $b->pivot->hbeli) * $b->pivot->quantity;
                    }
                    $p->laba = $laba;
                    $p->labaText = number_format($laba, 2, '.','.');
                    $p->tanggal = Carbon::createFromFormat("Y-m-d", $p->tanggal)->format("d/m/Y");
                    $p->totalText = number_format($p->total, 2, '.', '.');
                }

    			return view('report_penjualan.penjualan_print', compact('formattedTanggalAwal', 'formattedTanggalAkhir', 'penjualans'));
    			break;
    		default:
    			break;
    	}
    }

    public function generatePembelian(Request $request) {
        $tanggalAwal = Carbon::createFromFormat("m/d/Y", $request->input('awal'));
        $tanggalAkhir = Carbon::createFromFormat("m/d/Y", $request->input('akhir'));

        if ($tanggalAwal > $tanggalAkhir) 
            return redirect()->back()->with("status", "0||Cetak laporan gagal||Pastikan tanggal akhir lebih besar dari tanggal awal!");

        $formattedTanggalAwal = $tanggalAwal->format("D d M Y");
        $formattedTanggalAkhir = $tanggalAkhir->format("D d M Y");

        $pembelians = Pembelian::where("tanggal", ">=", $tanggalAwal->addDay(-1))->where("tanggal", "<=", $tanggalAkhir)->orderBy('tanggal', 'asc')->get();
        foreach ($pembelians as $p) {
            $p->totalText = number_format($p->total, 2, '.', '.');
            $p->tanggal = Carbon::createFromFormat("Y-m-d", $p->tanggal)->format("d/m/Y");
        }

        return view('report_pembelian.pembelian_print', compact('formattedTanggalAwal', 'formattedTanggalAkhir', 'pembelians'));
    }

    public function generateStok(Request $request) {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $barangs = Barang::with('penjualans')->get();
        foreach ($barangs as $b) {
            $penjualans = $b->penjualans()->whereYear('penjualans.tanggal', '=', $tahun)->whereMonth('penjualans.tanggal', '=', $bulan)->get();
            $pembelians = $b->pembelians()->whereYear('pembelians.tanggal', '=', $tahun)->whereMonth('pembelians.tanggal', '=', $bulan)->get();

            $b->terjual = 0;
            $b->masuk = 0;
            foreach($penjualans as $p) {
                $b->terjual += $p->pivot->quantity;
            } 

            foreach($pembelians as $p) {
                $b->masuk = $p->pivot->quantity;
            }
        }

        $periode = Carbon::createFromFormat("m Y", "$bulan $tahun")->format("M Y");
        return view('report.stok_print', compact('barangs', 'periode'));
    }
}
