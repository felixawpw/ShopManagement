<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembelian, App\Supplier, App\Barang, Auth;

class PembelianController extends Controller
{
    public function json(Request $request)
    {
        return "";
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

            $pembelians =  Pembelian::where('id','LIKE',"%{$search}%")
                            ->orWhere('nama', 'LIKE',"%{$search}%")
                            ->orWhere('kode', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Pembelian::where('id','LIKE',"%{$search}%")
                             ->orWhere('nama', 'LIKE',"%{$search}%")
                             ->orWhere('kode', 'LIKE',"%{$search}%")
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
                $nestedData['tanggal'] = $b->tanggal->toDateTimeString();
                $nestedData['tanggal_due'] = $b->tanggal_due->toDateTimeString();
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
        $suppliers = Supplier::all();
        return view('pembelian.create', compact('suppliers'));
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
        $pembelian->tanggal = $request->tanggal;
        $pembelian->total = 0;
        $pembelian->no_faktur = $request->no_faktur;
        $pembelian->supplier_id = $request->supplier_id;
        $pembelian->user_id = Auth::user()->id;
        $pembelian->save();

        $counter = 1;
        $total = 0;
        while (isset($request["id_$counter"]))
        {
            $idBarang = $request["id_$counter"];
            $qty = $request["jumlah_$counter"];
            $harga = $request["harga_$counter"];
            $subTotal = $qty * $harga;
            $total += $subTotal;
            $pembelian->barangs()->attach($idBarang, 
                ['quantity' => $qty, 'hbeli' => $harga, "subtotal" => $subTotal, "sisa" => $qty]);

            $barang = Pembelian::find($idBarang);
            $barang->stokTotal += $qty;
            $barang->save();
            $counter++;
        }
        $pembelian->total = $total;
        $pembelian->save();
        return redirect()->action('PembelianController@index');
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
        $pembelian->delete();
        return redirect()->action('PembelianController@index');
    }
}
