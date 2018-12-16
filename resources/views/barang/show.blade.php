@extends('layouts.master')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 ml-auto mr-auto">
      <div class="card " style="height: 700px;">
        <div class="card-header ">
          <h4 class="card-title">Product Informations
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
                          <label class="col-md-3 col-form-label" for="kode">Brand</label>
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
                  <div class="row">
                    <div class="col-md-6">
                     <h3>Filter Tampilan Data</h3> 
                    </div>
                  </div>

                  <div class="row">
                    
                  </div>

                  <div class="row">
                    <label class="col-md-1 col-form-label" for="nama">Periode</label>
                    <div class="col-md-3">
                      <div class="form-group">
                        <select class="selectpicker col-md-12" data-size="7" title="Single Select" id="penjualan_select_periode" data-style="select-with-transition">
                          <option disabled selected>Pilih salah satu</option>
                          <option value="1">Harian (+14 hari)</option>
                          <option value="2">Mingguan (+16 minggu)</option>
                          <option value="3">Bulanan (+12 bulan)</option>
                        </select>
                      </div>
                    </div>

                    <div id="penjualan_div_tanggal" class="col-md-4" hidden>
                      <div class="row">
                        <label class="col-md-3 col-form-label" for="penjualan_tanggal_awal">Tanggal Awal</label>
                        <div class="col-md-9">
                          <div class="form-group">
                            <input type="text" class="form-control datepicker" name="penjualan_tanggal_awal" id="penjualan_tanggal_awal" required>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="penjualan_div_bulan" class="col-md-4" hidden>
                      <div class="row">
                        <label class="col-md-3 col-form-label" for="penjualan_select_bulan">Bulan Awal</label>
                        <div class="col-md-6">
                          <div class="form-group">
                            <select class="selectpicker col-md-12" data-size="6" title="Single Select" id="penjualan_select_bulan" name="penjualan_select_bulan" data-style="select-with-transition">
                              <option disabled selected>Pilih salah satu</option>
                              <option value="1">Januari</option>
                              <option value="2">Februari</option>
                              <option value="3">Maret</option>
                              <option value="4">April</option>
                              <option value="5">Mei</option>
                              <option value="6">Juni</option>
                              <option value="7">Juli</option>
                              <option value="8">Agustus</option>
                              <option value="9">September</option>
                              <option value="10">Oktober</option>
                              <option value="11">November</option>
                              <option value="12">Desember</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <input type="text" class="form-control" name="penjualan_tahun_awal" id="penjualan_tahun_awal">
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <a href="#" class="btn btn-primary" onclick="loadPenjualan()">Submit</a>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div id="penjualan_chart" class="ct-chart"></div>  
                    </div>
                  </div>
                </div>


                <div class="tab-pane" id="detail_pembelian">
                  <div class="material-datatables">
                    <table id="pembelian_table" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nomor Nota</th>
                          <th>Tanggal Transaksi</th>
                          <th>Jatuh Tempo</th>
                          <th>Total</th>
                          <th>Nomor Faktur</th>
                          <th>Nama Supplier</th>
                          <th>Nama User</th>
                          <th>Status Pembayaran</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
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

    $('#pembelian_table').DataTable({
      "processing": true,
      "serverSide": true,
      "scrollX":true,
      "searching": false,
      "ajax":
        {
          "url": "{{ route('barang_pembelian_load', $barang->id) }}",
          "dataType": "json",
          "type": "POST",
          "data":{ _token: "{{csrf_token()}}"}
        },
      columnDefs: [ { orderable: false, targets: [6,7,9] } ],
      "columns": [
          { "data": "id" },
          { "data": "no_nota" },
          { "data": "tanggal" },
          { "data": "tanggal_due" },
          { "data": "total" },
          { "data": "no_faktur" },
          { "data": "nama_supplier" },
          { "data": "nama_user" },
          { "data": "status_pembayaran" },
          { "data": "options" }
      ]  
    });

    var table = $('#pembelian_table').DataTable();
	});

  function loadPenjualan() {

    var periode = $("#penjualan_select_periode").val();
    var awal = "";
    var year = 0;
    switch(periode) {
      case "1":
        awal = $("#penjualan_tanggal_awal").val();
        break;
      case "2":
        awal = $("#penjualan_tanggal_awal").val();
        break;
      case "3":
        awal = $("#penjualan_select_bulan").val();
        year = $("#penjualan_tahun_awal").val();
        break;
    }

    $.ajax({
      type:'GET',
      url: "{!! route('show_barang_penjualan', $barang->id) !!}",
      data: {
        periode: periode,
        awal: awal,
        year: year
      },
      success:function(data){
        console.log(data);
        var result = JSON.parse(data);
        var labels = [];
        var series = [];
        for (key in result) {
          labels.push(key);
          series.push(result[key]);
        }

        var data = {
          // A labels array that can contain any sort of values
          labels: labels,
          // Our series array that contains series objects or in this case series data arrays
          series: [
            series
          ]
        };

        var options = {
          plugins: [
            Chartist.plugins.tooltip()
          ],
          height: '500px'
        };
        // Create a new line chart object where as first parameter we pass in a selector
        // that is resolving to our chart container element. The Second parameter
        // is the actual data object.
        new Chartist.Bar('#penjualan_chart', data, options);

      },
    });
  }
</script>
@endsection