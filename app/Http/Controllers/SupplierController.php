<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier, App\Log, Auth;
class SupplierController extends Controller
{
    public function selectize(Request $request)
    {
        $query = $request->input("query");
        $suppliers = Supplier::where("nama", 'like', "%$query%")->get();
        return $suppliers;
    }

    public function json(Request $request)
    {
        $columns = array( 
            0 =>'id', 
            1 =>'nama',
            2 => 'alamat',
            3 => 'telepon',
            4 => 'fax',
            5 => 'namasales',
            6 => 'teleponsales',
            7 => 'pembelian_terakhir',
            8 => 'options',
        );
  
        $totalData = Supplier::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        
        if(empty($request->input('search.value')))
        {            
            $barangs = Supplier::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $barangs =  Supplier::where('id','LIKE',"%{$search}%")
                            ->orWhere('nama', 'LIKE',"%{$search}%")
                            ->orWhere('alamat', 'LIKE',"%{$search}%")
                            ->orWhere('fax', 'LIKE',"%{$search}%")
                            ->orWhere('telepon', 'LIKE',"%{$search}%")
                            ->orWhere('teleponsales', 'LIKE',"%{$search}%")
                            ->orWhere('namasales', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Supplier::where('id','LIKE',"%{$search}%")
                                ->orWhere('nama', 'LIKE',"%{$search}%")
                                ->orWhere('alamat', 'LIKE',"%{$search}%")
                                ->orWhere('fax', 'LIKE',"%{$search}%")
                                ->orWhere('telepon', 'LIKE',"%{$search}%")
                                ->orWhere('teleponsales', 'LIKE',"%{$search}%")
                                ->orWhere('namasales', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data = array();
        if(!empty($barangs))
        {
            foreach ($barangs as $b)
            {
                $show =  route('supplier.show',$b->id);
                $edit =  route('supplier.edit',$b->id);
                $delete = route('supplier.destroy',$b->id);

                $nestedData['id'] = $b->id;
                $nestedData['nama'] = $b->nama;
                $nestedData['alamat'] = $b->alamat;
                $nestedData['telepon'] = $b->telepon;
                $nestedData['fax'] = $b->fax;
                $nestedData['namasales'] = $b->namasales;
                $nestedData['teleponsales'] = $b->teleponsales;
                $nestedData['pembelian_terakhir'] = "-";
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('supplier.index', compact('suppliers'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('supplier.create');
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
        $supplier = new Supplier;
        $supplier->nama = $request->nama;
        $supplier->alamat = $request->alamat;
        $supplier->telepon = $request->telepon;
        $supplier->fax = $request->fax;
        $supplier->namasales = $request->namasales;
        $supplier->teleponsales = $request->teleponsales;

        $status = "1||Success||Berhasil menambahkan supplier $supplier->nama";
        try
        {
            $supplier->save();
            Log::create([
                'level' => "Info",
                'user_id' => Auth::id(),
                'action' => "Insert",
                'table_name' => "Suppliers",
                'description' => "Insert supplier success(ID = $supplier->id , Nama = $supplier->nama)",
            ]);
        }
        catch(\Exception $e)
        {
            Log::create([
                'level' => "Warning",
                'user_id' => Auth::id(),
                'action' => "Insert",
                'table_name' => "Suppliers",
                'description' => "Insert supplier failed. ".$e->getMessage(),
            ]);
            $status = "0||Failed||Gagal menambahkan supplier. Pastikan data yang dimasukkan sudah benar!";
        }
        return redirect()->action('SupplierController@index')->with('status', $status);
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
        $supplier = Supplier::find($id);
        return view('supplier.show', compact('supplier'));
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
        $supplier = Supplier::find($id);
        return view('supplier.edit', compact('supplier'));
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
        $supplier = Supplier::find($id);
        $supplier->nama = $request->nama;
        $supplier->alamat = $request->alamat;
        $supplier->telepon = $request->telepon;
        $supplier->fax = $request->fax;
        $supplier->namasales = $request->namasales;
        $supplier->teleponsales = $request->teleponsales;

        $status = "1||Success||Berhasil update supplier $supplier->nama";
        try
        {
            $supplier->save();
            Log::create([
                'level' => "Info",
                'user_id' => Auth::id(),
                'action' => "Update",
                'table_name' => "Suppliers",
                'description' => "Update supplier success(ID = $supplier->id , Nama = $supplier->nama)",
            ]);
        }
        catch(\Exception $e)
        {
            Log::create([
                'level' => "Warning",
                'user_id' => Auth::id(),
                'action' => "Update",
                'table_name' => "Suppliers",
                'description' => "Update supplier failed. ".$e->getMessage(),
            ]);
            $status = "0||Failed||Gagal update supplier. Pastikan data yang dimasukkan sudah benar!";
        }
        return redirect()->action('SupplierController@index')->with('status', $status);
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
        $supplier = Supplier::find($id);

        $status = 1;
        try
        {
            $supplier->delete();
            Log::create([
                'level' => "Info",
                'user_id' => Auth::id(),
                'action' => "Delete",
                'table_name' => "Suppliers",
                'description' => "Delete supplier success(ID = $supplier->id , Nama = $supplier->nama)",
            ]);
            $status = 1;
        }
        catch(\Exception $e)
        {
            Log::create([
                'level' => "Warning",
                'user_id' => Auth::id(),
                'action' => "Delete",
                'table_name' => "Suppliers",
                'description' => "Delete supplier failed. ".$e->getMessage(),
            ]);
            $status = 0;
        }
        return $status;
    }
}
