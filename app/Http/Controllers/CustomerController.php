<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer, App\Log, Auth;
use App\Penjualan;
use Carbon\Carbon;
class CustomerController extends Controller
{
    public function penjualanJson(Request $request)
    {
        $cId = $request->customer_id;

        $columns = array( 
            0 =>'id', 
            1 =>'no_nota',
            2 => 'no_faktur',
            3 => 'tanggal',
            4 => 'total',
            5 => 'nama_customer',
            6 => 'nama_user',
            7 => 'options'
        );
        $penjualans = Customer::find($cId)->penjualans();
        $totalData = $penjualans->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        
        if(empty($request->input('search.value')))
        {            
            $penjualans = $penjualans->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $tanggal = "";

            try {
                $tanggal = Carbon::createFromFormat('d', "$search")->toDateString();
            } catch (\Exception $ex) {

            }

            try {
                $tanggal = Carbon::createFromFormat('d M', "$search")->toDateString();
            } catch (\Exception $ex) {

            }

            try {
                $tanggal = Carbon::createFromFormat('d M Y', "$search")->toDateString();
            } catch (\Exception $ex) {

            }


            $penjualans =   Penjualan::whereHas('customer', function ($query) use ($search) {
                                $query->where('nama', 'LIKE', "%{$search}%");
                            })->orWhere('id','LIKE',"%{$search}%")
                                ->orWhere('no_nota', 'LIKE',"%{$search}%")
                                ->orWhere('no_faktur', 'LIKE', "%{$search}%")
                                ->orWhere('tanggal', '=', "$tanggal")
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();

            $totalFiltered = Penjualan::whereHas('customer', function ($query) use ($search) {
                                $query->where('nama', 'LIKE', "%{$search}%");
                            })->orWhere('id','LIKE',"%{$search}%")
                                ->orWhere('no_nota', 'LIKE',"%{$search}%")
                                ->orWhere('no_faktur', 'LIKE', "%{$search}%")
                                ->orWhere('tanggal', '=', "$tanggal")
                                ->count();
        }

        $data = array();
        if(!empty($penjualans))
        {
            foreach ($penjualans as $b)
            {
                $show =  route('penjualan.show',$b->id);
                $edit =  route('penjualan.edit',$b->id);
                $delete = route('penjualan.destroy',$b->id);

                $nestedData['id'] = $b->id;
                $nestedData['no_nota'] = $b->no_nota;
                $nestedData['no_faktur'] = $b->no_faktur;
                $nestedData['tanggal'] = date_format(date_create($b->tanggal), "d M Y");
                $nestedData['total'] = number_format($b->total, 0, '.', '.');
                $nestedData['nama_customer'] = $b->customer->nama;
                $nestedData['nama_user'] = $b->user->nama;
                $nestedData['options'] = 
                "<a href='$show' class='btn btn-link btn-info btn-just-icon show'><i class='material-icons'>favorite</i></a>
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
            6 => 'total_pembelian',
            7 => 'options'
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

            $customers =  Customer::where('id','LIKE',"%{$search}%")
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
                $nestedData['total_pembelian'] = number_format($b->penjualans->sum("total"));
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
        return view('customer.index', compact('customers'));
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

        $status = "1||Selamat||Berhasil menambahkan pelanggan $customer->nama";
        try
        {
            $customer->save();
            Log::create([
                'level' => "Info",
                'user_id' => Auth::id(),
                'action' => "Insert",
                'table_name' => "Customers",
                'description' => "Insert customer success(ID = $customer->id , Nama = $customer->nama)",
            ]);
        }
        catch(\Exception $e)
        {
            Log::create([
                'level' => "Warning",
                'user_id' => Auth::id(),
                'action' => "Insert",
                'table_name' => "Customers",
                'description' => "Insert customer failed. ".$e->getMessage(),
            ]);
            $status = "0||Perhatian||Gagal menambahkan pelanggan. Pastikan data yang dimasukkan sudah benar!";
        }
        
        if ($request->tipe == "ajax")
            return $customer;
        else
            return redirect()->action('CustomerController@index')->with('status', $status);
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
        $year = Carbon::now()->year;

        return view('customer.show', compact('customer', 'year', 'kp'));
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
        $customer->hp = $request->hp;
        $customer->fax = $request->fax;

        $status = "1||Selamat||Berhasil update customer $customer->nama";
        try
        {
            $customer->save();
            Log::create([
                'level' => "Info",
                'user_id' => Auth::id(),
                'action' => "Update",
                'table_name' => "Customers",
                'description' => "Update pelanggan success(ID = $customer->id , Nama = $customer->nama)",
            ]);
        }
        catch(\Exception $e)
        {
            Log::create([
                'level' => "Warning",
                'user_id' => Auth::id(),
                'action' => "Update",
                'table_name' => "Customers",
                'description' => "Update customer failed. ".$e->getMessage(),
            ]);
            $status = "0||Perhatian||Gagal mengupdate pelanggan. Pastikan data yang dimasukkan sudah benar!";
        }
        
        return redirect()->action('CustomerController@index')->with('status', $status);
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

        $status = 1;
        try
        {
            $customer->delete();
            Log::create([
                'level' => "Info",
                'user_id' => Auth::id(),
                'action' => "Delete",
                'table_name' => "Customers",
                'description' => "Delete customer",
            ]);
        }
        catch(\Exception $e)
        {
            Log::create([
                'level' => "Warning",
                'user_id' => Auth::id(),
                'action' => "Delete",
                'table_name' => "Customers",
                'description' => "Delete customer failed. ".$e->getMessage(),
            ]);
            $status = 0;
        }

        return 1;
    }
}
