<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembelian, App\Supplier, App\Barang, App\Log, Auth;
use Carbon\Carbon, DB;
use App\Method;
class PembelianController extends Controller
{
    public function json(Request $request)
    {
        $columns = array( 
            0 =>'id', 
            1 =>'no_nota',
            2 => 'tanggal',
            3 => 'tanggal_due',
            4 => 'total',
            5 => 'no_faktur',
            6 => 'nama_supplier',
            7 => 'nama_user',
            8 => 'status_pembayaran',
            9 => 'options'
        );
  
        $totalData = Pembelian::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        
        if(empty($request->input('search.value')))
        {            
            $pembelians = Pembelian::offset($start)
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

            $pembelians =   Pembelian::whereHas('supplier', function ($query) use ($search) {
                                $query->where('nama', 'LIKE', "%{$search}%");
                            })
                            ->orwhere('id','LIKE',"%{$search}%")
                            ->orWhere('no_nota', 'LIKE',"%{$search}%")
                            ->orWhere('tanggal', '=',"$tanggal")
                            ->orWhere('tanggal_due', '=',"$tanggal")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Pembelian::where('id','LIKE',"%{$search}%")
                             ->orWhere('no_nota', 'LIKE',"%{$search}%")
                             ->orWhere('tanggal', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data = array();
        if(!empty($pembelians))
        {
            foreach ($pembelians as $b)
            {
                $show =  route('pembelian.show',$b->id);
                $edit =  route('pembelian.edit',$b->id);
                $delete = route('pembelian.destroy',$b->id);

                $nestedData['id'] = $b->id;
                $nestedData['no_nota'] = $b->no_nota;
                $nestedData['tanggal'] = date_format(date_create($b->tanggal), "d M Y");
                $nestedData['tanggal_due'] = date_format(date_create($b->tanggal_due), "d M Y");
                $nestedData['total'] = number_format($b->total, 0, '.', '.');
                $nestedData['no_faktur'] = $b->no_faktur;
                $nestedData['nama_supplier'] = $b->supplier->nama;
                $nestedData['nama_user'] = $b->user->nama;
                $nestedData['status_pembayaran'] = $b->status_pembayaran == 1 ? "Lunas" : "Belum Lunas";
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
        //
        return view('pembelian.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $p = Pembelian::whereDate('created_at', '=', Carbon::now()->format("Y-m-d"))->count() + 1;
        $p = sprintf('%03d', $p);
        $date = Carbon::now()->format("d-m-Y");
        $no_nota = "SP/PB/$date/$p";
        $date = Carbon::now()->format("dmY-");
        $no_faktur = "B-$date$p";
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        return view('pembelian.create', compact('no_nota' , 'suppliers', 'barangs', 'no_faktur'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pembelian = new Pembelian;
        $pembelian->no_nota = $request->no_nota;
        $pembelian->tanggal = Method::date_format($request->tanggal, "Y-m-d");
        $pembelian->tanggal_due = Method::date_format($request->tanggal_due, "Y-m-d");
        $pembelian->total = 0;
        $pembelian->no_faktur = $request->no_faktur;
        $pembelian->supplier_id = $request->supplier;
        $pembelian->user_id = Auth::user()->id;
        $pembelian->status_pembayaran = $request->status_pembayaran;
        $status = "1||Selamat||Berhasil menambahkan transaksi pembelian dengan nomor nota $pembelian->no_nota";
        DB::beginTransaction();
        try
        {
            $pembelian->save();
            $total = 0;
            $res = $request->max_counter;
            for ($i = 0; $i <= $request->max_counter; $i++)
            {
                if (isset($request["id_$i"]))
                {
                    $idBarang = $request["id_$i"];
                    $qty = $request["jumlah_$i"];
                    $harga = str_replace(".","",$request["hbeli_$i"]);
                    $subTotal = $qty * $harga;
                    $total += $subTotal;
                    $pembelian->barangs()->attach($idBarang, 
                        ['quantity' => $qty, 'hbeli' => $harga, "sisa" => $qty]);
                    $barang = Barang::find($idBarang);
                    $barang->stoktotal += $qty;
                    $barang->save();
                }
            }
            $pembelian->total = $total;
            $pembelian->save();
            Log::create([
                'level' => "Info",
                'user_id' => Auth::id(),
                'action' => "Insert",
                'table_name' => "Pembelians",
                'description' => "Insert pembelian success(ID = $pembelian->id , No Nota = $pembelian->no_nota)",
            ]);
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            Log::create([
                'level' => "Warning",
                'user_id' => Auth::id(),
                'action' => "Insert",
                'table_name' => "Pembelians",
                'description' => "Insert pembelian failed. ".$e->getMessage(),
            ]);
            $status = "0||Perhatian||Gagal menambahkan pembelian. Pastikan data yang dimasukkan sudah benar!";
        }
        DB::commit();
        return redirect()->action('PembelianController@index')->with("status", $status);
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
        $pembelian = Pembelian::find($id);
        return view('pembelian.show', compact('pembelian'));
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
        return view('pembelian.edit');
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
        $pembelian = Pembelian::find($id);
        $status = 1;
        try
        {
            $barangs = $pembelian->barangs;
            foreach($barangs as $b)
            {
                $qty = $b->pivot->quantity;
                $b->stoktotal -= $qty;
                $b->save();
            }
            $pembelian->delete();
            
            Log::create([
                'level' => "Info",
                'user_id' => Auth::id(),
                'action' => "Delete",
                'table_name' => "Pembelians",
                'description' => "Delete pembelian success(ID = $pembelian->id, Supplier = ".$pembelian->supplier->nama.")",
            ]);
        }
        catch(\Exception $e)
        {
            Log::create([
                'level' => "Warning",
                'user_id' => Auth::id(),
                'action' => "Delete",
                'table_name' => "Pembelians",
                'description' => "Delete pembelian failed. ".$e->getMessage(),
            ]);
            $status = 0;
        }
        return $status;
    }
}
