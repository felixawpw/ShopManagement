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
              <h4 class="card-title">Edit Barang</h4>
            </div>
            <div class="card-body ">
              <form class="form-horizontal" method="POST" action="{{ route('barang.update', $barang->id) }}">
                {{csrf_field()}}
                @method('PUT')
                <div class="row">
                  <label class="col-md-3 col-form-label" for="kode">Kode Barang</label>
                  <div class="col-md-7">
                    <div class="form-group has-default">
                      <input type="text" class="form-control" name="kode" id="kode" required value="{!! $barang->kode !!}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-3 col-form-label" for="nama">Nama Barang</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" class="form-control" name="nama" id="nama" required value="{!! $barang->nama !!}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-3 col-form-label" for="hjual">Merk Barang</label>
                  <div class="col-md-3">
                    <div class="form-group">
                      <select class="selectized" placeholder="Type to search or add Brand" name="brand" id="brand">
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <label class="col-md-3 col-form-label" for="hjual">Jenis Produk</label>
                  <div class="col-md-3">
                    <div class="form-group">
                      <select class="selectized" placeholder="Type to search or add Product Type" name="product_type" id="product_type">
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <label class="col-md-3 col-form-label" for="kodeharga">Kode Harga</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" class="form-control" name="kodeharga" id="kodeharga" required value="{!! $barang->kodeharga !!}">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <label class="col-md-3 col-form-label" for="hbeli">Harga Beli (Rp.)</label>
                  <div class="col-md-1">
                    <div class="form-group">
                      <input type="text" class="form-control text-right" name="hbeli" id="hbeli" oninput="number_format(this)" required value="{!! number_format($barang->hbeli, 0, '.', '.') !!}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-3 col-form-label" for="hjual">Harga Jual (Rp.)</label>
                  <div class="col-md-1">
                    <div class="form-group">
                      <input type="text" class="form-control text-right" name="hjual" id="hjual" oninput="number_format(this)" required value="{!! number_format($barang->hjual, 0, '.', '.') !!}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-3 col-form-label" for="stoktotal">Stok Total</label>
                  <div class="col-md-1">
                    <div class="form-group">
                      <input type="text" class="form-control text-right" name="stoktotal" id="stoktotal" oninput="number_format(this)" required value="{!! number_format($barang->stoktotal, 0, '.', '.') !!}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-3 col-form-label" for="hgrosir">Harga Grosir (Rp.)</label>
                  <div class="col-md-1">
                    <div class="form-group">
                      <input type="text" class="form-control text-right" name="hgrosir" id="hgrosir" oninput="number_format(this)" required value="{!! number_format($barang->hgrosir, 0, '.', '.') !!}">
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
    $('#nav_barang').addClass('active');

    $('#brand').selectize({
      valueField: "id",
      labelField: "nama",
      searchField: "nama",
      sortField: [{field: 'nama', direction: 'asc'}],
      options: {!! $brands !!},
      create:function(input, callback){
        $.ajax({
          url: '{!! route("brand.store") !!}',
          type: 'POST',
          data: {
            nama: input,
          },
          dataType: "json",
          success: function (result) {
            if (result) {
              callback({ id: result.id, nama: result.nama });
            }
          }
        });
      },
      onInitialize: function(){
        this.setValue({!! $barang->brand_id !!});
      } 
    });
    $('#product_type').selectize({
      valueField: "id",
      labelField: "nama",
      searchField: "nama",
      sortField: [{field: 'nama', direction: 'asc'}],
      options: {!! $pts !!},
      create:function(input, callback){
        $.ajax({
          url: '{!! route("product-type.store") !!}',
          type: 'POST',
          data: {
            nama: input,
          },
          dataType: "json",
          success: function (result) {
            console.log(result);
            if (result) {
              callback({ id: result.id, nama: result.nama });
            }
          }
        });
      },
      onInitialize: function(){
        this.setValue({!! $barang->product_type_id !!});
      } 

    });
  });
</script>
@endsection