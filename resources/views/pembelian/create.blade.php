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
              <h4 class="card-title">Tambah Barang</h4>
            </div>
            <div class="card-body ">
              <form class="form-horizontal" method="POST" action="{{ route('pembelian.store') }}">
                {{csrf_field()}}
                <div class="row">
                  <label class="col-md-3 col-form-label" for="kode">Nomor Nota</label>
                  <div class="col-md-7">
                    <div class="form-group has-default">
                      <input type="text" class="form-control" id="nomor_nota" required disabled value="{!! $no_nota !!}">
                      <input type="hidden" name="no_nota" value="{!! $no_nota !!}">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <label class="col-md-3 col-form-label" for="hbeli">Nomor Faktur</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" class="form-control" name="no_faktur" id="no_faktur" required>
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
                  <label class="col-md-3 col-form-label" for="kodeharga">Jatuh Tempo</label>
                  <div class="col-md-3">
                    <div class="form-group">
                      <input type="text" class="form-control datepicker" name="tanggal_due" id="tanggal_due" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <label class="col-md-3 col-form-label" for="hjual">Supplier</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <select class="selectpicker" data-style="select-with-transition" multiple title="Choose Supplier" data-size="7" name="supplier" id="supplier">
                      @foreach($suppliers as $s)
                        <option value="{!! $s->id !!}">{!! $s->nama !!}</option>
                      @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <label class="col-md-3 col-form-label" for="hgrosir">Status Pembayaran</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <select class="selectpicker" data-style="select-with-transition" multiple title="Choose Status Pembayaran" data-size="7" name="status_pembayaran" id="status_pembayaran">
                        <option value="1">Lunas</option>
                        <option value="2">BG</option>
                      </select>
                    </div>
                  </div>
                </div>  
                
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="material-datatables">
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                          <thead>
                            <tr>
                              <th>Kode Barang</th>
                              <th>Nama Barang</th>
                              <th>Stok Barang</th>
                              <th>Jumlah Barang</th>
                              <th>Harga Jual</th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th colspan="3"></th>
                              <th>Grand Total</th>
                              <th id="grand_total">Rp. 0,00</th>
                            </tr>
                            <tr>
                              <td colspan="5" class="text-center"><a class="btn btn-link btn-primary" onclick="show_barang()">Tambah Barang</a></td>
                            </tr>
                          </tfoot>
                          <tbody>
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-7 offset-md-3">
                    <div class="form-group">
                      <button type="submit" class="btn btn-fill btn-primary col-md-12">Submit</button>
                    </div>
                  </div>
                </div>
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
	$(document).ready(function(){
		$('#nav_pembelian').addClass('active');
    md.initFormExtendedDatetimepickers();
    if ($('.slider').length != 0) {
      md.initSliders();
    }
	});

  function show_barang()
  {
    swal({
      title: 'Input something',
      html: '<div class="form-group">' +
        '<input id="input-field" type="text" class="form-control" />' +
        '</div>',
      showCancelButton: true,
      confirmButtonClass: 'btn btn-success',
      cancelButtonClass: 'btn btn-danger',
      buttonsStyling: false
    }).then(function(result) {
      swal({
        type: 'success',
        html: 'You entered: <strong>' +
          $('#input-field').val() +
          '</strong>',
        confirmButtonClass: 'btn btn-success',
        buttonsStyling: false

      })
    }).catch(swal.noop);

  }
</script>
@endsection