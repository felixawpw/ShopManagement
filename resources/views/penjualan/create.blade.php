@extends('layouts.master')

@section('content')
<div class="container-fluid">
  <div class="row">
      <div class="col-md-12">
          <div class="card ">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">add</i>
              </div>
              <h4 class="card-title">Tambah Penjualan</h4>
            </div>
            <div class="card-body ">
              <form class="form-horizontal" method="POST" action="{{ route('penjualan.store') }}">
                {{csrf_field()}}
                <div class="row">
                  <label class="col-md-3 col-form-label" for="kode">Nomor Nota</label>
                  <div class="col-md-7">
                    <div class="form-group has-default">
                      <input type="text" class="form-control" id="nomor_nota" disabled value="{!! $no_nota !!}">
                      <input type="hidden" name="no_nota" value="{!! $no_nota !!}">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <label class="col-md-3 col-form-label" for="hbeli">Nomor Invoice/Faktur</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" class="form-control" id="no_faktur" disabled value="{!! $no_faktur !!}">
                      <input type="hidden" name="no_faktur" value="{!! $no_faktur !!}">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <label class="col-md-3 col-form-label" for="nama">Tanggal</label>
                  <div class="col-md-3">
                    <div class="form-group">
                      <input type="text" class="form-control datepicker" name="tanggal" id="tanggal" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <label class="col-md-3 col-form-label" for="hjual">Pelanggan</label>
                  <div class="col-md-3">
                    <div class="form-group">
                      <select class="selectized" placeholder="Pilih/buat pelanggan" name="customer" id="select_customer">
                      </select>
                    </div>
                  </div>
                </div>
                                
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="material-datatables">
                        <table id="table_cart" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                          <thead>
                            <tr>
                              <th>Kode Barang</th>
                              <th>Nama Barang</th>
                              <th>Stok Barang</th>
                              <th>Jumlah Barang</th>
                              <th>Harga Jual</th>
                              <th>Sub Total (Rp.)</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <td colspan="2">
                                <select id="select_barang" placeholder="Ketikkan kode/nama barang untuk tambah item"></select>
                              </td>
                            </tr>
                            <tr>
                              <th colspan="4"></th>
                              <th>Grand Total (Rp.)</th>
                              <th colspan="2"><input type="text" id="grand_total" class="form-control" disabled></th>
                            </tr>
                          </tfoot>
                          <tbody id="table_cart_body">
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-7 offset-md-3">
                    <div class="form-group">
                      <button type="submit" class="btn btn-fill btn-primary col-md-12">Simpan</button>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="max_counter" id="max_counter" value="0">
              </form>
            </div>
            <div class="card-footer ">
              <div class="row">
                <div class="col-md-7">
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
  var barangs = new Array;
  var cartCounter = 0;
  $(document).ready(function(){
    $('#nav_penjualan').addClass('active');
    $('#nav_transaksi').addClass('active');

    
    md.initFormExtendedDatetimepickers();
    if ($('.slider').length != 0) {
      md.initSliders();
    }
    $('#select_customer').selectize({
      valueField: 'id',
      labelField: 'nama',
      searchField: ['nama'],
      sortField: [{field: 'nama', direction: 'asc'}],
      create:function(input, callback){
        $.ajax({
          url: '{!! route("customer.store") !!}',
          type: 'POST',
          data: {
            nama: input,
            tipe: "ajax"
          },
          dataType: "json",
          success: function (result) {
            if (result) {
              callback({ id: result.id, nama: result.nama });
            }
          }
        });
      },
      load: (query, callback) => {
        if (query.length) {
          $.ajax({
            url: "{!! route('selectize_customer') !!}",
            data: { query: query},
            dataType: "json",
            type: 'GET',
            error: function(e) {
              callback();
              console.log(e);
            },
            success: function(res) {
              console.log(res);
              callback(res);
            } 
          });
        }
      },
    });


    $('#select_barang').selectize({
      valueField: 'id',
      labelField: 'nama',
      searchField: ['kode', 'nama'],
      render: {
        item: function(item, escape) {
          return '<div class="item">' +
              (item.kode ? '<span class="kode_barang">' + escape(item.kode) + '</span>' : '') +
          '</div>';
        },
        option: function(item, escape) {
            var label = item.kode;
            var description = item.nama;
            return '<div class="custom-dropdown-option">' +
              '<div class="row">' +
                '<div class="col-md-12">'+
                  '<h5>'+ escape(label) + '<br><small>' + escape(description) + '</small>' + '</h5>' +
                '</div>' +
              '</div>' +
            '</div>';
        }
      },
      load: (query, callback) => {
        if (query.length) {
          $.ajax({
            url: "{!! route('selectize_barang') !!}",
            data: { query: query},
            dataType: "json",
            type: 'GET',
            error: function(e) {
              callback();
              console.log(e);
            },
            success: function(res) {
              console.log(res);
              barangs = res;
              callback(res);
            } 
          });
        }
      },
      onChange: function(item){
        console.log("Change " + item);
        if (item)
        {
          var idxBarang = binarySearch(barangs, item);
          var barang = barangs[idxBarang];
          appendToTable(barang);

          $('#max_counter').val(cartCounter);
          cartCounter++;

          this.setValue(null);
        }
      }
    });
  });

  function appendToTable(barang)
  {
    var div = "" +
    "<tr id='tr_" + cartCounter +"'>" +
      "<td>" + "<input type='hidden' name='id_" + cartCounter + "' value='" + barang.id + "'>" + "<input type='text' disabled placeholder='Kode' class='form-control' name='kode_" + cartCounter + "' id='kode_" + cartCounter + "' value='" + barang.kode +"'>" + "</td>" +
      "<td>" + "<input type='text' disabled placeholder='Nama' class='form-control' name='nama_" + cartCounter + "' id='nama_" + cartCounter + "' value='" + barang.nama +"'>" + "</td>" +
      "<td>" + "<input type='text' disabled placeholder='Stok' class='form-control' name='stok_" + cartCounter + "' id='stok_" + cartCounter + "' value='" + barang.stoktotal + "'>" + "</td>" +
      "<td>" + "<input type='text' oninput='number_format(this); changeTotals(" + cartCounter + ");' placeholder='Quantity' class='form-control' name='jumlah_" + cartCounter + "' id='jumlah_" + cartCounter + "' value='1'>"  + "</td>" +
      "<td>" + "<input type='text' oninput='number_format(this); changeTotals(" + cartCounter + ");' placeholder='H.Jual' class='form-control' name='hjual_" + cartCounter + "' id='hjual_" + cartCounter + "' value='" + parseInt(barang.hjual).format(0,3,'.', ',') + "'>" + "</td>" +
      "<td>" + "<input type='text' disabled placeholder='Sub Total' class='form-control' name='subtotal_" + cartCounter + "' id='subtotal_" + cartCounter + "' value='" + parseInt(barang.hjual).format(0,3,'.', ',') + "'>" + "</td>" +
      "<td><a href='#' class='btn btn-link btn-danger btn-just-icon remove' onclick='removeRow(" + cartCounter + ")'><i class='material-icons'>close</i></a></td>" +
    "</tr>";
    $('#table_cart_body').append(div);
  }

  function changeTotals(idx)
  {
    var qty = parseInt($("#jumlah_" + idx).val().replace(/\./g, ""));
    var hbeli = parseInt($("#hjual_" + idx).val().replace(/\./g, ""));
    $("#subtotal_" + idx).val((qty * hbeli).format(0,3,'.', ','));
    getGrandTotal();
  }

  function removeRow(idx)
  {
    $("#tr_" + idx).remove();
    getGrandTotal();
  }

  function getGrandTotal()
  {
    var grandTotal = 0;
    for (var i = 0; i < cartCounter; i++)
    {
      if($("#subtotal_" + i).val() != null)
        grandTotal += parseInt($("#subtotal_" + i).val().replace(/\./g, ""));
    }
    $("#grand_total").val(grandTotal.format(0,3,'.', ','));
  }
</script>
@endsection