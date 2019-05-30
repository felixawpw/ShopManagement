<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier, App\Barang, App\Customer;
class AjaxController extends Controller
{
    //
    public function test()
    {
        $barang = Barang::find(1);
        $pembelian = $barang->pembelians()->wherePivot('sisa', '>', 0)->orderBy("pembelians.created_at", 'asc')
            ->orderBy('pembelians.created_at')->first();
        $barang->hbeli = $pembelian->pivot->hbeli;
        $barang->save();

        return $barang;
    }


    public function addSupplier()
    {
    	return view('template.supplier');
    }
    public function storeSupplier(Request $request)
    {
    	$supplier = new Supplier;
        $supplier->nama = $request->nama;
        $supplier->alamat = $request->alamat;
        $supplier->telepon = $request->telepon;
        $supplier->fax = $request->fax;
        $supplier->namasales = $request->namasales;
        $supplier->teleponsales = $request->teleponsales;
        $supplier->save();
    	return $supplier->id."&".$supplier->nama;
    }

    public function addCustomer()
    {
        return view('template.customer');
    }

    public function storeCustomer(Request $request)
    {
        $customer = new Customer;
        $customer->nama = $request->nama;
        $customer->alamat = $request->alamat;
        $customer->telepon = $request->telepon;
        $customer->hp = $request->hp;
        $customer->fax = $request->fax;
        $customer->save();
        return $customer->id."&".$customer->nama;
    }
   
}
