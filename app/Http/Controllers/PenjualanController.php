<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang, App\Penjualan, App\Customer, App\Supplier, App\Log, Auth;
use App\Pembelian;
use Carbon\Carbon, DB;
use PDF;
use App\Method;
class PenjualanController extends Controller
{
    public function json(Request $request)
    {
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
  
        $totalData = Penjualan::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        
        if(empty($request->input('search.value')))
        {            
            $pembelians = Penjualan::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $pembelians =  Penjualan::where('id','LIKE',"%{$search}%")
                            ->orWhere('no_nota', 'LIKE',"%{$search}%")
                            ->orWhere('no_faktur', 'LIKE', "%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Penjualan::where('id','LIKE',"%{$search}%")
                            ->orWhere('no_nota', 'LIKE',"%{$search}%")
                            ->orWhere('no_faktur', 'LIKE', "%{$search}%")
                             ->count();
        }

        $data = array();
        if(!empty($pembelians))
        {
            foreach ($pembelians as $b)
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

    public function invoice($id)
    {
        $penjualan = Penjualan::find($id);
        return view('penjualan.invoice', compact("penjualan"));
    }

    public function suratjalan($id)
    {
        $penjualan = Penjualan::find($id);
        return view('penjualan.suratjalan', compact("penjualan"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('penjualan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $p = Penjualan::whereDate('created_at', '=', Carbon::now()->format("Y-m-d"))->get();
        $max = 0;
        foreach ($p as $pe) {
            $number = explode("/", $pe->no_nota);
            $max = max($max, (int)$number[3]);
        }
        $max = $max+1;
        $p = sprintf('%03d', $max);

        $date = Carbon::now()->format("d-m-Y");
        $no_nota = "SP/PJ/$date/$p";
        $date = Carbon::now()->format("dmY-");
        $no_faktur = "PB$date$p";
        $barangs = Barang::all();
        $customers = Customer::all();
        return view('penjualan.create', compact('no_nota', 'barangs', 'no_faktur', 'customers'));
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

        $penjualan = new Penjualan;
        $penjualan->no_nota = $request->no_nota;
        $penjualan->no_faktur = $request->no_faktur;
        $penjualan->tanggal = Method::date_format($request->tanggal, "Y-m-d");
        $penjualan->total = $request->total;
        $penjualan->customer_id = $request->customer;
        $penjualan->user_id = Auth::user()->id;
        $penjualan->total = 0;

        $status = "1||Selamat||Berhasil menambahkan transaksi penjualan dengan nomor nota $penjualan->no_nota";
        DB::beginTransaction();
        try
        {
            $penjualan->save();
            $total = 0;
            $res = $request->max_counter;
            for ($i = 0; $i <= $request->max_counter; $i++)
            {
                if (isset($request["id_$i"]))
                {
                    $idBarang = $request["id_$i"];
                    $qty = $request["jumlah_$i"];
                    $harga = str_replace(".","",$request["hjual_$i"]);
                    $subTotal = $qty * $harga;
                    $total += $subTotal;

                    $barang = Barang::find($idBarang);
                    $barang->stoktotal -= $qty;
                    $barang->save();

                    $pembeliansBarang = $barang->pembelians()->wherePivot("quantity", ">", 0)->get();
                    
                    $tempQty = $qty;
                    $pointerPembeliansBarang = 0;
                    $countPembeliansBarang = $pembeliansBarang->count();
                    
                    $hbeli = 0;

                    while ($tempQty > 0)
                    {
                        if ($pointerPembeliansBarang >= $countPembeliansBarang)
                        {
                            $hbeli = ($hbeli + $barang->hbeli * $tempQty);
                            $tempQty = 0;
                        }
                        else
                        {
                            $pbn = $pembeliansBarang[$pointerPembeliansBarang];
                            $totalDipakai = 0;
                            if ($pbn->pivot->sisa < $tempQty)
                            {
                                $totalDipakai = $pbn->pivot->sisa;
                                $pbn->pivot->sisa = 0;
                            }
                            else
                            {
                                $totalDipakai = $tempQty;
                                $pbn->pivot->sisa -= $tempQty;
                            }
                            $barang->pembelians()->updateExistingPivot($pbn->id, ["sisa" => $pbn->pivot->sisa]);
                            $hbeli = ($hbeli + $pbn->pivot->hbeli * $totalDipakai);
                            $tempQty -= $totalDipakai;
                        }
                        $pointerPembeliansBarang++;
                    }
                    $hbeli /= $qty;
                    $penjualan->barangs()->attach($idBarang, 
                        ['quantity' => $qty, 'hbeli' => $hbeli,'hjual' => $harga]);

                }
            }
            $penjualan->total = $total;
            $penjualan->save();
            Log::create([
                'level' => "Info",
                'user_id' => Auth::id(),
                'action' => "Insert",
                'table_name' => "Penjualans",
                'description' => "Insert penjualan success(ID = $penjualan->id , No Nota = $penjualan->no_nota)",
            ]);
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            Log::create([
                'level' => "Warning",
                'user_id' => Auth::id(),
                'action' => "Insert",
                'table_name' => "Penjualans",
                'description' => "Insert penjualan failed. ".$e->getMessage(),
            ]);
            $status = "0||Perhatian||Gagal menambahkan penjualan. Pastikan data yang dimasukkan sudah benar!";
        }
        DB::commit();
        if ($status[0] == "1")
            return redirect()->action('PenjualanController@show', $penjualan->id)->with("status", $status);
        else
            return redirect()->action('PenjualanController@index')->with("status", $status);
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
        $penjualan = Penjualan::find($id);
        return view('penjualan.show', compact('penjualan'));
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
        $penjualan = Penjualan::find($id);
        $status = 1;
        try
        {
            $barangs = $penjualan->barangs;
            foreach($barangs as $b)
            {
                $qty = $b->pivot->quantity;
                $hbeli = $b->hbeli;

                $hbeliBaru = ($hbeli * $b->stoktotal + $b->pivot->hbeli * $qty)/($qty + $b->stoktotal);
                $b->stoktotal += $qty;
                $b->hbeli = $hbeliBaru;
                $b->save();
            }
            $penjualan->delete();
            
            Log::create([
                'level' => "Info",
                'user_id' => Auth::id(),
                'action' => "Delete",
                'table_name' => "Penjualans",
                'description' => "Delete penjualan success(ID = $penjualan->id, Cust = ".$penjualan->customer->nama.")",
            ]);
        }
        catch(\Exception $e)
        {
            Log::create([
                'level' => "Warning",
                'user_id' => Auth::id(),
                'action' => "Delete",
                'table_name' => "Penjualans",
                'description' => "Delete penjualan failed. ".$e->getMessage(),
            ]);
            $status = 0;
        }
        return $status;
    }
}
