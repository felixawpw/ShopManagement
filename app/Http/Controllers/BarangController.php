<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Barang;
class BarangController extends Controller
{
    public function json(Request $request)
    {
        $columns = array( 
            0 =>'id', 
            1 =>'kode',
            2 => 'nama',
            3 => 'hbeli',
            4 => 'hjual',
            5 => 'stoktotal',
            6 => 'updated_at',
            7 => 'options',
        );
  
        $totalData = Barang::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        
        if(empty($request->input('search.value')))
        {            
            $barangs = Barang::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $barangs =  Barang::where('id','LIKE',"%{$search}%")
                            ->orWhere('nama', 'LIKE',"%{$search}%")
                            ->orWhere('kode', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Barang::where('id','LIKE',"%{$search}%")
                             ->orWhere('nama', 'LIKE',"%{$search}%")
                             ->orWhere('kode', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data = array();
        if(!empty($barangs))
        {
            foreach ($barangs as $b)
            {
                $show =  route('barang.show',$b->id);
                $edit =  route('barang.edit',$b->id);
                $delete = route('barang.destroy',$b->id);

                $nestedData['id'] = $b->id;
                $nestedData['kode'] = $b->kode;
                $nestedData['nama'] = $b->nama;
                $nestedData['hbeli'] = number_format($b->hbeli, 0, '.', '.');
                $nestedData['hjual'] = number_format($b->hjual, 0, '.', '.');
                $nestedData['stoktotal'] = number_format($b->stoktotal, 0, '.', '.');
                $nestedData['updated_at'] = $b->updated_at == null ? "" : $b->updated_at->toDateTimeString();
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
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('barang.create');
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
        $barang = new Barang;
        $barang->kode = $request->kode;
        $barang->nama = $request->nama;
        $barang->kodeharga = $request->kodeharga;
        $barang->hbeli = str_replace('.', '', $request->hbeli);
        $barang->hjual = str_replace('.', '', $request->hjual);
        $barang->stoktotal = str_replace('.', '', $request->stoktotal);
        $barang->hgrosir = str_replace('.', '', $request->hgrosir);

        $status = "1||Success||Berhasil menambahkan barang $barang->kode : $barang->nama";
        try
        {
            $barang->save();
        }
        catch(\Exception $e)
        {
            
        }
        return redirect()->action('BarangController@index')->with('status', $status);
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
        $barang = Barang::find($id);
        return view('barang.show', compact('barang'));
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
        $barang = Barang::find($id);
        return view('barang.edit', compact('barang'));
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
        $barang = Barang::find($id);
        $barang->kode = $request->kode;
        $barang->nama = $request->nama;
        $barang->kodeharga = $request->kodeharga;
        $barang->hbeli = $request->hbeli;
        $barang->hjual = $request->hjual;
        $barang->stoktotal = $request->stoktotal;
        $barang->hgrosir = $request->hgrosir;

        $barang->save();
        return redirect()->action('BarangController@index');
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
        $barang = Barang::find($id);
        $barang->delete();
        return 1;
    }
}
