<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier, App\Barang, App\Customer;
use App\Penjualan;
use Carbon\Carbon;
class AjaxController extends Controller
{
    //
    public function test()
    {
        $try = "";
        try {
            $try = Carbon::createFromFormat('d', '1 Apr');
        } catch (\Exception $ex) {

        }

        try {
            $try = Carbon::createFromFormat('d M', '1 Apr');
        } catch (\Exception $ex) {

        }

        try {
            $try = Carbon::createFromFormat('d M', '1 Apr');
        } catch (\Exception $ex) {

        }
        return $try;
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
