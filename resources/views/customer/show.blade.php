@extends('layouts.master')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 ml-auto mr-auto">
      <div class="card ">
        <div class="card-header ">
          <h4 class="card-title">Informasi Customer
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
                  <a class="nav-link" data-toggle="tab" href="#detail_penjualan_bulanan" role="tablist">
                    <i class="material-icons">calendar_today</i> Total Penjualan Bulanan
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#detail_penjualan" role="tablist">
                    <i class="material-icons">shopping_cart</i> Data Penjualan
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
                              <input type="text" class="form-control" disabled value="{!! $customer->nama !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Alamat (Invoice)</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $customer->alamat !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Alamat (Surat Jalan)</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $customer->alamat_2 !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">NPWP</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $customer->npwp !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">E-Mail</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $customer->email !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Telepon</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $customer->telepon !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Fax</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $customer->fax !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">HP</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! $customer->hp !!}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label" for="kode">Piutang</label>
                          <div class="col-md-9">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" disabled value="{!! number_format($customer->penjualans->sum('piutang'), 0, ',', '.') !!}">
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                
                <div class="tab-pane" id="detail_penjualan_bulanan">
                  <div class="material-datatables">
                    <table id="omset_table" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>Bulan</th>
                          <th>Penjualan Bulanan</th>
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
                              $customer->penjualans()->whereMonth("tanggal", $i)->whereYear("tanggal", $year)->sum("total"),
                                0, ",", ".")
                              !!}
                            </td>
                          </tr>
                        @endfor
                      </tbody>
                    </table>
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
                        @foreach ($customer->penjualans as $b)
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

    $("#penjualan_table").DataTable();
  });

</script>
@endsection