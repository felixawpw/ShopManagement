@extends('layouts.master')

@section('content')
<div class="container-fluid">
	<div class="row">
    	<div class="col-md-12">
          <div class="card ">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">contacts</i>
              </div>
              <h4 class="card-title">Tambah Barang</h4>
            </div>
            <div class="card-body ">
              <form class="form-horizontal" method="POST" action="{{ route('barang.store') }}">
                {{csrf_field()}}
                <div class="row">
                  <label class="col-md-3 col-form-label" for="kode">Kode Barang</label>
                  <div class="col-md-7">
                    <div class="form-group has-default">
                      <input type="text" class="form-control" name="kode" id="kode">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-3 col-form-label" for="nama">Nama Barang</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" class="form-control" name="nama" id="nama">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <label class="col-md-3 col-form-label" for="kodeharga">Kode Harga</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" class="form-control" name="kodeharga" id="kodeharga">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <label class="col-md-3 col-form-label" for="hbeli">Harga Beli</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" class="form-control" name="hbeli" id="hbeli" oninput="number_format(this)">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-3 col-form-label" for="hjual">Harga Jual</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" class="form-control" name="hjual" id="hjual" oninput="number_format(this)">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-3 col-form-label" for="stoktotal">Stok Total</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" class="form-control" name="stoktotal" id="stoktotal" oninput="number_format(this)">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-3 col-form-label" for="hgrosir">Harga Grosir</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" class="form-control" name="hgrosir" id="hgrosir" oninput="number_format(this)">
                    </div>
                  </div>
                </div>  
                <div class="row">
                  <div class="col-md-7 offset-md-3">
                    <div class="form-group">
                      <button type="submit" class="btn btn-fill btn-primary col-md-12">Sign in</button>
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
		$('#nav_barang').addClass('active');
	});
</script>
@endsection