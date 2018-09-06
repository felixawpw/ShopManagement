@extends('layouts.master')

@section('content')
<div class="container-fluid">
          <div class="row">
            <div class="col-md-8 ml-auto mr-auto">
              <div class="page-categories">
                <h3 class="title text-center">{!! $barang->kode !!}</h3>
                <br />
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#description" role="tablist">
                      <i class="material-icons">info</i> Description
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#penjualan" role="tablist">
                      <i class="material-icons">location_on</i> Penjualan
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#pembelian" role="tablist">
                      <i class="material-icons">gavel</i> Pembelian
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#forecast" role="tablist">
                      <i class="material-icons">help_outline</i> Forecast
                    </a>
                  </li>
                </ul>
                <div class="tab-content tab-space tab-subcategories">
                  <div class="tab-pane active" id="description">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">Product Description</h4>
                        <p class="card-category">
                          
                        </p>
                      </div>
                      <div class="card-body">
                      	<div class="row">
                      		<div class="col-md-8">
			                    <div class="form-group">
			                      <label class="bmd-label-floating">Kode Barang</label>
			                      <input type="text" class="form-control" disabled value="{!! $barang->kode !!}">
			                    </div>
                      		</div>
                      		<div class="col-md-4">
			                    <div class="form-group">
			                      <label class="bmd-label-floating">Stok Total</label>
			                      <input type="text" class="form-control" disabled value="{!! number_format($barang->stoktotal, 0, '.', '.') !!}">
			                    </div>
                      		</div>
                      	</div>
                      	<div class="row">
                      		<div class="col-md-12">
			                    <div class="form-group">
			                      <label class="bmd-label-floating">Nama Barang</label>
			                      <input type="text" class="form-control" disabled value="{!! $barang->nama !!}">
			                    </div>
                      		</div>
                      	</div>
                      	<div class="row">
                      		<div class="col-md-4">
			                    <div class="form-group">
			                      <label class="bmd-label-floating">Harga Beli</label>
			                      <input type="text" class="form-control" disabled value="Rp. {!! number_format($barang->hbeli, 0, '.', '.') !!}">
			                    </div>
                      		</div>
                      		<div class="col-md-4">
			                    <div class="form-group">
			                      <label class="bmd-label-floating">Harga Jual</label>
			                      <input type="text" class="form-control" disabled value="Rp. {!! number_format($barang->hbeli, 0, '.', '.') !!}">
			                    </div>
                      		</div>
                      		<div class="col-md-4">
		  	                  <div class="form-group">
			                      <label class="bmd-label-floating">Harga Grosir</label>
			                      <input type="text" class="form-control" disabled value="Rp. {!! number_format($barang->hgrosir, 0, '.', '.') !!}">
			                    </div>
                      		</div>
                      	</div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="penjualan">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">Penjualan</h4>
                        <p class="card-category">
                          More information here
                        </p>
                      </div>
                      <div class="card-body">
                      	
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="pembelian">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">Legal info of the product</h4>
                        <p class="card-category">
                          More information here
                        </p>
                      </div>
                      <div class="card-body">
                        Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.
                        <br>
                        <br>Dynamically innovate resource-leveling customer service for state of the art customer service.
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="forecast">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">Help center</h4>
                        <p class="card-category">
                          More information here
                        </p>
                      </div>
                      <div class="card-body">
                        From the seamless transition of glass and metal to the streamlined profile, every detail was carefully considered to enhance your experience. So while its display is larger, the phone feels just right.
                        <br>
                        <br> Another Text. The first thing you notice when you hold the phone is how great it feels in your hand. The cover glass curves down around the sides to meet the anodized aluminum enclosure in a remarkable, simplified design.
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
	});
</script>
@endsection