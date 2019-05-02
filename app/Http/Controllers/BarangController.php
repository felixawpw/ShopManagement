<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Barang, App\Log, Auth, App\Brand, App\ProductType;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Penjualan;
use DB;
class BarangController extends Controller
{


    public function selectize(Request $request)
    {
        $query = $request->input("query");
        $barangs = Barang::all();
        return $barangs;
    }

    public function barangPembelianJSON(Request $request, $id) {
        $barang = Barang::find($id);
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
  
        $totalData = $barang->pembelians()->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        
        if(empty($request->input('search.value')))
        {            
            $pembelians = $barang->pembelians()->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            // $pembelians =  $barang->pembelians()->where('id','LIKE',"%{$search}%")
            //                 ->orWhere('no_nota', 'LIKE',"%{$search}%")
            //                 ->orWhere('kode', 'LIKE',"%{$search}%")
            //                 ->offset($start)
            //                 ->limit($limit)
            //                 ->orderBy($order,$dir)
            //                 ->get();

            // $totalFiltered = $barang->pembelians()->where('pembelians.id','LIKE',"%{$search}%")
            //                  ->orWhere('pembelians.nama', 'LIKE',"%{$search}%")
            //                  ->orWhere('pembelians.kode', 'LIKE',"%{$search}%")
            //                  ->count();
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

    public function json(Request $request)
    {
        $columns = array( 
            0 =>'id', 
            1 =>'kode',
            2 => 'nama',
            3 => 'brand',
            4 => 'product_type',
            5 => 'hbeli',
            6 => 'hjual',
            7 => 'stoktotal',
            8 => 'updated_at',
            9 => 'options',
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

            $bp1 =  Barang::where('id','LIKE',"%{$search}%")
                            ->orWhere('nama', 'LIKE',"%{$search}%")
                            ->orWhere('kode', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $byBrand = Brand::where('nama', 'LIKE', "%{$search}%")->get();
            $byProductType = ProductType::where('nama', 'LIKE', "%{$search}%")->get();

            $barangs = new Collection($bp1);

            foreach($byBrand as $b)
            {
                $barangs = $barangs->merge(new Collection($b->barangs));
            }

            foreach($byProductType as $b)
            {
                $barangs = $barangs->merge(new Collection($b->barangs));
            }


            $barangs = $barangs->unique("id")->all();


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
                $nestedData['brand'] = $b->brand->nama;
                $nestedData['product_type'] = $b->product_type->nama;
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

    public function reportPenjualan(Request $request, $id) {
        try {
            $barang = Barang::find($id);

            $periode = $request->periode;
            $awal = $request->awal;            
            $year = $request->year;
            switch ($periode) {
                case '1':
                    $formattedDateAwal = Carbon::createFromFormat("m/d/Y", $awal);
                    for ($i = 0; $i < 14; $i++) {
                        $penjualans = DB::table("barang_penjualan")
                            ->join('penjualans', 'barang_penjualan.penjualan_id', '=', 'penjualans.id')
                            ->select(DB::raw('sum(barang_penjualan.quantity) as sum'))
                            ->where("barang_id", "=", $barang->id)
                            ->whereDate("penjualans.tanggal", "=", $formattedDateAwal->toDateString())
                            ->first();

                        $result[$formattedDateAwal->toDateString()] = $penjualans->sum;
                        $formattedDateAwal = $formattedDateAwal->addDay(1);
                    }
                    break;
                case '2':                    
                    $formattedDateAwal = Carbon::createFromFormat("m/d/Y", $awal);
                    $last = $formattedDateAwal;
                    $result = array();
                    for ($i = 0; $i < 16; $i++) {
                        $dateAkhir = Carbon::createFromFormat("m/d/Y", $awal)->addDay(($i + 1) * 7);

                        $penjualans = DB::table("barang_penjualan")
                                ->join('penjualans', 'barang_penjualan.penjualan_id', '=', 'penjualans.id')
                                ->where("barang_id", "=", $barang->id)
                                ->whereDate("penjualans.tanggal", ">=", $last)
                                ->whereDate("penjualans.tanggal", "<=", $dateAkhir)
                                ->select(DB::raw("sum(barang_penjualan.quantity) as sum"))
                                ->first();

                        $result[$last->toDateString()] = $penjualans->sum;
                        $last = $dateAkhir;
                    }
                    break;
                case '3':
                    $result = array();
                    $month = $awal;
                    //$year, $month
                    for ($i = 0; $i < 12; $i++) {
                        $currMonth = $month;

                        $month++;

                        if ($month > 12) {
                            $month = 1;
                            $year++;
                        }

                        $penjualans = DB::table("barang_penjualan")
                                ->join('penjualans', 'barang_penjualan.penjualan_id', '=', 'penjualans.id')
                                ->where("barang_id", "=", $barang->id)
                                ->whereMonth("penjualans.tanggal", "=", $month)
                                ->whereYear("penjualans.tanggal", "=", $year)
                                ->select(DB::raw("sum(barang_penjualan.quantity) as sum"))
                                ->first();

                        $result["$year - $currMonth"] = $penjualans->sum;
                    }

                    break;                
                default:
                    break;
            }
            return json_encode($result);
        } catch (Exception $ex) {
            return "Failed";
        }
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
        $brands = \App\Brand::all();
        $pts = \App\ProductType::all();
        return view('barang.create', compact('brands', 'pts'));
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
        $barang->brand_id = $request->brand;
        $barang->product_type_id = $request->product_type;

        $status = "1||Selamat||Berhasil menambahkan barang $barang->kode : $barang->nama";
        try
        {
            $barang->save();
            Log::create([
                'level' => "Info",
                'user_id' => Auth::id(),
                'action' => "Insert",
                'table_name' => "Barangs",
                'description' => "Insert barang success(ID = $barang->id , Nama = $barang->nama)",
            ]);
        }
        catch(\Exception $e)
        {
            Log::create([
                'level' => "Warning",
                'user_id' => Auth::id(),
                'action' => "Insert",
                'table_name' => "Barangs",
                'description' => "Insert barang failed. ".$e->getMessage(),
            ]);
            $status = "0||Perhatian||Gagal menambahkan barang. Pastikan data yang dimasukkan sudah benar!";
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
        $brands = \App\Brand::all();
        $pts = \App\ProductType::all();
        return view('barang.edit', compact('barang', 'brands', 'pts'));
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
        $barang->hbeli = str_replace('.', '', $request->hbeli);
        $barang->hjual = str_replace('.', '', $request->hjual);
        $barang->stoktotal = str_replace('.', '', $request->stoktotal);
        $barang->hgrosir = str_replace('.', '', $request->hgrosir);
        $barang->brand_id = $request->brand;
        $barang->product_type_id = $request->product_type;
        
        $status = "1||Selamat||Berhasil mengupdate barang $barang->kode : $barang->nama";
        try
        {
            $barang->save();
            Log::create([
                'level' => "Info",
                'user_id' => Auth::id(),
                'action' => "Update",
                'table_name' => "Barang",
                'description' => "Update barang success(ID = $barang->id , Nama = $barang->nama)",
            ]);
        }
        catch(\Exception $e)
        {
            Log::create([
                'level' => "Warning",
                'user_id' => Auth::id(),
                'action' => "Update",
                'table_name' => "Barang",
                'description' => "Update barang failed. ".$e->getMessage(),
            ]);
            $status = "0||Perhatian||Gagal update barang. Pastikan data yang dimasukkan sudah benar!";
        }
        return redirect()->action('BarangController@index')->with('status', $status);
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
        $status = 1;
        try
        {
            $barang->delete();
            Log::create([
                'level' => "Info",
                'user_id' => Auth::id(),
                'action' => "Delete",
                'table_name' => "Barang",
                'description' => "Delete barang success(ID = $barang->id , Nama = $barang->nama)",
            ]);
        }
        catch(\Exception $e)
        {
            Log::create([
                'level' => "Warning",
                'user_id' => Auth::id(),
                'action' => "Delete",
                'table_name' => "Barang",
                'description' => "Delete barang failed. ".$e->getMessage(),
            ]);
            $status = 0;
        }
        return $status;
    }
}
