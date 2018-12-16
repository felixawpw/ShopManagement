<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
class CustomerController extends Controller
{
    public function selectize(Request $request)
    {
        $query = $request->input("query");
        $customers = Customer::where("nama", 'like', "%$query%")->get();
        return $customers;
    }

    public function json(Request $request)
    {
        $columns = array( 
            0 =>'id', 
            1 =>'nama',
            2 => 'alamat',
            3 => 'telepon',
            4 => 'hp',
            5 => 'fax',
            6 => 'options'
        );
  
        $totalData = Customer::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        
        if(empty($request->input('search.value')))
        {            
            $customers = Customer::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $bp1 =  Customer::where('id','LIKE',"%{$search}%")
                            ->orWhere('nama', 'LIKE',"%{$search}%")
                            ->orWhere('alamat', 'LIKE',"%{$search}%")
                            ->orWhere('telepon', 'LIKE',"%{$search}%")
                            ->orWhere('hp', 'LIKE',"%{$search}%")
                            ->orWhere('fax', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $customers = $customers->unique("id")->all();

            $totalFiltered = Customer::where('id','LIKE',"%{$search}%")
                                ->orWhere('nama', 'LIKE',"%{$search}%")
                                ->orWhere('alamat', 'LIKE',"%{$search}%")
                                ->orWhere('telepon', 'LIKE',"%{$search}%")
                                ->orWhere('hp', 'LIKE',"%{$search}%")
                                ->orWhere('fax', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data = array();
        if(!empty($customers))
        {
            foreach ($customers as $b)
            {
                $show =  route('customer.show',$b->id);
                $edit =  route('customer.edit',$b->id);
                $delete = route('customer.destroy',$b->id);

                $nestedData['id'] = $b->id;
                $nestedData['nama'] = $b->nama;
                $nestedData['alamat'] = $b->alamat == null ? "-" : $b->alamat;
                $nestedData['telepon'] = $b->telepon == null ? "-" : $b->telepon;
                $nestedData['hp'] = $b->hp == null ? "-" : $b->hp;
                $nestedData['fax'] = $b->fax == null ? "-" : $b->fax;
                $nestedData['options'] = 
                "<a href='$show' class='btn btn-link btn-info 
                btn-just-icon show'><i class='material-icons'>favorite</i></a>
                <a href='$edit' class='btn btn-link btn-warning btn-just-icon edit'><i class='material-icons'>dvr</i></a>
                <button type='submit' class='btn btn-link btn-danger btn-just-icon remove' onclick='delete_confirmation(event,\"$delete\" )'><i class='material-icons'>close</i></button>";
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        return json_encode($json_data);    
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
