<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Penjualan, App\Pembelian, App\Barang;
use DB;
use App;
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
        $jumlahTotalBarang = 0;
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
                    $laba = 0;
                    $omset = 0;

                    foreach($penjualans as $p) {
                        $barangs = $p->barangs;
                        foreach ($barangs as $b) {
                            $laba += ($b->pivot->hjual - $b->pivot->hbeli) * $b->pivot->quantity / 1000;
                            $omset += $b->pivot->hjual * $b->pivot->quantity / 1000;
                            $jumlahTotalBarang += $b->pivot->quantity;

                            $resultTipeBarang[$b->product_type->nama] = (isset($resultTipeBarang[$b->product_type->nama]) ? $resultTipeBarang[$b->product_type->nama] : 0) + $b->pivot->quantity;
                            $resultBrand[$b->brand->nama] = (isset($resultBrand[$b->brand->nama]) ? $resultBrand[$b->brand->nama] : 0) + $b->pivot->quantity;
                        }
                        $resultLaba[$temp->toDateString()] = $laba;
                        $resultOmset[$temp->toDateString()] = $omset;
                    }

                    $temp->addDay(1);
                }
                return view('report_penjualan.penjualan_grafik', compact('resultLaba', 'resultOmset', 'resultTipeBarang', 'resultBrand', 'formattedTanggalAwal', 'formattedTanggalAkhir', 'jumlahTotalBarang'));
                break;
            case 'printout':
                foreach ($penjualans as $p) {
                    $laba = 0;
                    $hpp = 0;
                    $dpp = 0;
                    $barangs = $p->barangs;
                    foreach($barangs as $b) {
                        $hpp += $b->pivot->hbeli * $b->pivot->quantity;
                        $dpp += ($b->pivot->hjual - $b->pivot->discount) * $b->pivot->quantity;
                        $laba += $dpp - $hpp;
                    }
                    $p->laba = $laba;
                    $p->hpp = $hpp;
                    $p->dpp = $dpp;
                    $p->tanggal = Carbon::createFromFormat("Y-m-d", $p->tanggal)->format("d/m/Y");
                    $p->totalText = number_format($p->total, 2, '.', '.');
                }

                $pdf = App::make('dompdf.wrapper');
                $pdf->setPaper('A4', 'landscape');

                $pdf = $pdf->loadView('report_penjualan.penjualan_print', compact('formattedTanggalAwal', 'formattedTanggalAkhir', 'penjualans'));
                return $pdf->stream();
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
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'landscape');

        $pdf = $pdf->loadView('report_pembelian.pembelian_print', compact('formattedTanggalAwal', 'formattedTanggalAkhir', 'pembelians'));
        return $pdf->stream();
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
