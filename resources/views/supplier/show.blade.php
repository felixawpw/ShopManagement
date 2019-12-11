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
                    <i class="material-icons">dashboard</i> Detail Customer
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#detail_pembelian_bulanan" role="tablist">
                    <i class="material-icons">schedule</i> Total Pembelian Bulanan
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#detail_pembelian" role="tablist">
                    <i class="material-icons">schedule</i> Data Pembelian
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
                          <label class="col-md-3 col-form-label" for="kode">Nama</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $supplier->nama !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Alamat</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $supplier->alamat !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">NPWP</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $supplier->npwp !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">E-Mail</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $supplier->email !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Telepon</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $supplier->telepon !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Fax</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $supplier->fax !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Nama Sales</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $supplier->namasales !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Telepon Sales</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $supplier->teleponsales !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Bank</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $supplier->bank !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Rekening</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $supplier->nomor_rekening !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Hutang</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! number_format($supplier->pembelians->sum('hutang'), 0, ',', '.') !!}">
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                
                <div class="tab-pane" id="detail_pembelian_bulanan">
                  <div class="material-datatables">
                    <table id="omset_table" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>Bulan</th>
                          <th>Pembelian Bulanan</th>
                        </tr>
                      </thead>
                      <tbody>
                        @for ($i = 1; $i <= 12; $i++)
                          <tr>
                            @switch($i)
                              @case(1)
                                <td>Januari</td>
                                @break
                              @case(2)
                                <td>Februari</td>
                                @break
                              @case(3)
                                <td>Maret</td>
                                @break
                              @case(4)
                                <td>April</td>
                                @break
                              @case(5)
                                <td>Mei</td>
                                @break
                              @case(6)
                                <td>Juni</td>
                                @break
                              @case(7)
                                <td> Juli</td>
                                @break
                              @case(8)
                                <td>Agustus</td>
                                @break
                              @case(9)
                                <td>September</td>
                                @break
                              @case(10)
                                <td>Oktober</td>
                                @break
                              @case(11)
                                <td>November</td>
                                @break
                              @case(12)
                                <td>Desember</td>
                                @break
                            @endswitch
                            <td>
                              {!! number_format(
                              $supplier->pembelians()->whereMonth("tanggal", $i)->whereYear("tanggal", $year)->sum("total"),
                                0, ",", ".")
                              !!}
                            </td>
                          </tr>
                        @endfor
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
                          <th class="disabled-sorting text-right">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($supplier->pembelians as $b)
                          <tr>
                            <td>{!! $b->no_nota !!}</td>
                            <td>{!! $b->no_faktur !!}</td>
                            <td>{!! date_format(date_create($b->tanggal), "d M Y") !!}</td>
                            <td>{!! $b->jatuh_tempo !!}</td>
                            <td>{!! number_format($b->total, 0, ',', '.') !!}</td>
                            <td>{!! $b->supplier->nama !!}</td>
                            <td>{!! $b->hutang == 0 ? "Lunas" : "Kredit ".number_format($b->hutang, 0, ',', '.') !!}</td>
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
    $('#nav_customer').addClass('active');
    $('#nav_relation').addClass('active');

    md.initFormExtendedDatetimepickers();
    if ($('.slider').length != 0) {
      md.initSliders();
    }
    $('#omset_table').DataTable({
      "ordering":false,
      "pageLength": 12
    });

    $("#pembelian_table").DataTable();
  });

</script>
@endsection