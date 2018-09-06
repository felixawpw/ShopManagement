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
              <h4 class="card-title">Tambah Supplier</h4>
            </div>
            <div class="card-body ">
              <form class="form-horizontal" method="POST" action="{{ route('supplier.update', $supplier->id) }}">
                {{csrf_field()}}
                @method('PUT')
                <div class="row">
                  <label class="col-md-3 col-form-label" for="nama">Nama Supplier</label>
                  <div class="col-md-7">
                    <div class="form-group has-default">
                      <input type="text" class="form-control" name="nama" id="nama" required value="{!! $supplier->nama !!}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-3 col-form-label" for="alamat">Alamat</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" class="form-control" name="alamat" id="alamat" required value="{!! $supplier->alamat !!}">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <label class="col-md-3 col-form-label" for="telepon">Telepon Supplier</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" class="form-control" name="telepon" id="telepon" required value="{!! $supplier->telepon !!}">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <label class="col-md-3 col-form-label" for="fax">Nomor Fax</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" class="form-control" name="fax" id="fax" required value="{!! $supplier->fax !!}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-3 col-form-label" for="namasales">Nama Sales</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" class="form-control" name="namasales" id="namasales" required value="{!! $supplier->namasales !!}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-3 col-form-label" for="teleponsales">Telepon Sales</label>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" class="form-control" name="teleponsales" id="teleponsales" required value="{!! $supplier->teleponsales !!}">
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
        $('#nav_supplier').addClass('active');
    });
</script>
@endsection