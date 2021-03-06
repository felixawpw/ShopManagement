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
                $resultBrandOmset = array();
                $totalOmset = 0;
                $totalLaba = 0;

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

                            $resultTipeBarangOmset[$b->product_type->nama] = (isset($resultTipeBarangOmset[$b->product_type->nama]) ? $resultTipeBarangOmset[$b->product_type->nama] : 0) + ($b->pivot->quantity) * $b->pivot->hjual;
                            $resultTipeBarangLaba[$b->product_type->nama] = (isset($resultTipeBarangLaba[$b->product_type->nama]) ? $resultTipeBarangLaba[$b->product_type->nama] : 0) + ($b->pivot->quantity) * ($b->pivot->hjual - $b->pivot->hbeli);

                            $resultBrandOmset[$b->brand->nama] = (isset($resultBrandOmset[$b->brand->nama]) ? $resultBrandOmset[$b->brand->nama] : 0) + ($b->pivot->quantity) * $b->pivot->hjual;
                            $resultBrandLaba[$b->brand->nama] = (isset($resultBrandLaba[$b->brand->nama]) ? $resultBrandLaba[$b->brand->nama] : 0) + ($b->pivot->quantity) * ($b->pivot->hjual - $b->pivot->hbeli);

                            $totalOmset += $b->pivot->quantity * $b->pivot->hjual;
                            $totalLaba += $b->pivot->quantity * ($b->pivot->hjual - $b->pivot->hbeli);
                        }
                        $resultLaba[$temp->toDateString()] = $laba;
                        $resultOmset[$temp->toDateString()] = $omset;
                    }

                    $temp->addDay(1);
                }
                return view('report_penjualan.penjualan_grafik', compact('resultLaba', 'totalOmset', 'totalLaba', 'resultTipeBarangOmset','resultTipeBarangLaba','resultBrandLaba', 'resultBrandOmset', 'resultOmset', 'resultTipeBarang', 'resultBrand', 'formattedTanggalAwal', 'formattedTanggalAkhir', 'jumlahTotalBarang'));
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
            case 'brand_category':
                $tempAwal = $tanggalAwal->copy()->addDay(-1);
                $sales = DB::select("
                    select y.nama as 'category', x.nama, t.quantity, x.hbeli, x.hjual
                    from barangs x inner join product_types y on x.product_type_id = y.id
                        inner join (
                        select c.product_type_id as product_type_id, c.id as barang_id, sum(b.quantity) as quantity
                        from penjualans a 
                            inner join barang_penjualan b on a.id = b.penjualan_id 
                            inner join barangs c on b.barang_id = c.id
                        where a.tanggal >= '$tempAwal' and a.tanggal <= '$tanggalAkhir'
                        group by c.product_type_id, c.id
                        order by c.product_type_id) t on x.id = t.barang_id
                        where y.nama = 'LED TV' or y.nama = 'Kulkas' or y.nama like '%Mesin Cuci%' or y.nama like '%Speaker%' or y.nama = 'AC' or y.nama = 'Show Case' or y.nama like '%Freezer%'
                        order by category, t.quantity DESC
                        
                    "
                );
                // return view('report_penjualan.penjualan_category', compact('formattedTanggalAwal', 'formattedTanggalAkhir', 'sales'));
                $pdf = App::make('dompdf.wrapper');
                $pdf->setPaper('A4', 'landscape');

                $pdf = $pdf->loadView('report_penjualan.penjualan_category', compact('formattedTanggalAwal', 'formattedTanggalAkhir', 'sales'));
                return $pdf->stream();

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
