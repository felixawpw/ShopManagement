<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
class CustomerController extends Controller
{

    public function json()
    {
        return Customer::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customers = Customer::all();
        return view('customer.index', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('customer.create');
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
        $customer = new Customer;
        if ($request->tipe == "ajax")
        {
            $customer->nama = $request->nama;
        }
        else
        {
            $customer->nama = $request->nama;
            $customer->alamat = $request->alamat;
            $customer->telepon = $request->telepon;
            $customer->alamat = $request->alamat;
            $customer->hp = $request->hp;
            $customer->fax = $request->fax;
            $customer->hutang = 0;
            $customer->deposit = 0;
        }
        $customer->save();
        
        if ($request->tipe == "ajax")
            return $customer;
        else
            return redirect()->action('CustomerController@index');
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
        $customer = Customer::find($id);
        return view('customer.show', compact('customer'));
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
        $customer = Customer::find($id);
        return view('customer.edit', compact('customer'));
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
        $customer = Customer::find($id);
        $customer->nama = $request->nama;
        $customer->alamat = $request->alamat;
        $customer->telepon = $request->telepon;
        $customer->alamat = $request->alamat;
        $customer->hp = $request->hp;
        $customer->fax = $request->fax;
        $customer->hutang = $request->hutang;
        $customer->deposit = $request->deposit;
        $customer->save();
        return redirect()->action('CustomerController@index');
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
        $customer = Customer::find($id);
        $customer->delete();
        return redirect()->action('CustomerController@index');
    }
}
