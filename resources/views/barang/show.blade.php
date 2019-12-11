@extends('layouts.master')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 ml-auto mr-auto">
      <div class="card ">
        <div class="card-header ">
          <h4 class="card-title">Informasi Produk
            <small class="description"></small>
          </h4>
        </div>
        <div class="card-body ">
          <div class="row">
            <div class="col-md-2">
              <!--
                  color-classes: "nav-pills-primary", "nav-pills-info", "nav-pills-success", "nav-pills-warning","nav-pills-danger"
              -->
              <ul class="nav nav-pills nav-pills-primary nav-pills-icons flex-column" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#detail_produk" role="tablist">
                    <i class="material-icons">dashboard</i> Detail Produk
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#detail_penjualan" role="tablist">
                    <i class="material-icons">schedule</i> Penjualan
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#detail_pembelian" role="tablist">
                    <i class="material-icons">schedule</i> Pembelian
                  </a>
                </li>
              </ul>
            </div>
            <div class="col-md-10">
              <div class="tab-content">
                <div class="tab-pane active" id="detail_produk">
                  <div class="row">
                    <div class="col-md-6">
                      <form class="form-horizontal" action="#" onsubmit="event.preventDefault();">
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Kode Barang</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $barang->kode !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Nama Barang</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $barang->nama !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Jenis Barang</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $barang->product_type->nama !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Merk Barang</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $barang->brand->nama !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Stok Total</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $barang->stoktotal !!}">
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-6">
                      <form class="form-horizontal" action="#" onsubmit="event.preventDefault();">
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Kode Harga</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $barang->kodeharga !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Harga Beli</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" id="hbeli" disabled value="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Harga Jual</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" id="hjual" disabled value="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Harga Grosir</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" id="hgrosir" disabled value=>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                
                <div class="tab-pane" id="detail_penjualan">
                  <div class="material-datatables">
                    <table id="penjualan_table" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>No Faktur</th>
                          <th>No PO</th>
                          <th>Tanggal</th>
                          <th>Nama Customer</th>
                          <th>Total</th>
                          <th class="disabled-sorting text-right">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($barang->penjualans as $b)
                          <tr>
                            <td>{!! $b->no_faktur !!}</td>
                            <td>{!! $b->no_nota !!}</td>
                            <td>{!! date_format(date_create($b->tanggal), "d M Y") !!}</td>
                            <td>{!! $b->customer->nama !!}</td>
                            <td>{!! number_format($b->total, '0', ',', '.') !!}</td>
                            <td>
                              <a href='{!! route("penjualan.show", $b->id) !!}' class='btn btn-link btn-info btn-just-icon show'><i class='material-icons'>visibility</i></a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>


                <div class="tab-pane" id="detail_pembelian">
                  <div class="material-datatables">
                    <table id="pembelian_table" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>Nomor Nota</th>
                          <th>Nomor Faktur</th>
                          <th>Tanggal Transaksi</th>
                          <th>Jatuh Tempo</th>
                          <th>Total</th>
                          <th>Nama Supplier</th>
                          <th>Status Pembayaran</th>
                          <th>Harga Beli</th>
                          <th>Sisa Stok</th>
                          <th class="disabled-sorting text-right">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($barang->pembelians as $b)
                          <tr>
                            <td>{!! $b->no_nota !!}</td>
                            <td>{!! $b->no_faktur !!}</td>
                            <td>{!! date_format(date_create($b->tanggal), "d M Y") !!}</td>
                            <td>{!! $b->jatuh_tempo !!}</td>
                            <td>{!! number_format($b->total, 0, ',', '.') !!}</td>
                            <td>{!! $b->supplier->nama !!}</td>
                            <td>{!! $b->hutang == 0 ? "Lunas" : "Kredit ".number_format($b->hutang, 0, ',', '.') !!}</td>
                            <td>{!! number_format($b->pivot->hbeli, 0, ',', '.') !!}</td>
                            <td>{!! $b->pivot->sisa !!}</td>
                            <td>
                              <a href='{!! route("pembelian.show", $b->id) !!}' class='btn btn-link btn-info btn-just-icon show'><i class='material-icons'>visibility</i></a>
                              <a href='{!! route("pembelian.edit", $b->id) !!}' class='btn btn-link btn-info btn-just-icon show'><i class='material-icons'>dvr</i></a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>

                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function(){
    $('#nav_barang').addClass('active');
    console.log($("#hbeli").val());
    md.initFormExtendedDatetimepickers();
    if ($('.slider').length != 0) {
      md.initSliders();
    }

    var hbeli = {!! $barang->hbeli !!};
    var hjual = {!! $barang->hjual !!};
    var hgrosir = {!! $barang->hgrosir !!};

    $("#hbeli").val(parseInt(hbeli).format(0,3,".", ","));
    $("#hjual").val(parseInt(hjual).format(0,3,".", ","));
    $("#hgrosir").val(parseInt(hgrosir).format(0,3,".", ","));


    $("#penjualan_select_periode").change(function(){
      var selectedVal = $(this).val();
      var tgl = $("#penjualan_div_tanggal");
      var bulan = $("#penjualan_div_bulan");

      switch(selectedVal) {
        case "1":
          tgl.removeAttr("hidden");
          bulan.attr("hidden", true);
          break;
        case "2":
          tgl.removeAttr("hidden");
          bulan.attr("hidden", true);
          break;
        case "3": 
          bulan.removeAttr("hidden");
          tgl.attr("hidden", true);
          break;
      }
    });

    $('#penjualan_table').DataTable({
      "scrollX": true
    });

    $('#pembelian_table').DataTable({
      "scrollX": true
    });

    var table = $('#pembelian_table').DataTable();
  });
</script>
@endsection