@extends('layouts.master')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 ml-auto mr-auto">
      <div class="card">
        <div class="card-header card-header-primary card-header-icon">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
          <h4 class="card-title">Data Barang</h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-6">
              <p class="" style="font-size: 24px;">
                <b>Sripuja Elektronik</b><br>
                Jl. Danau Buyan no. 12, Negara, Bali<br>
                Telp. (0365) 41713
              </p>
            </div>
            <div class="col-md-3 ml-auto">
              <p class="text-primary" style="font-size: 24px;">NOTA PEMBELIAN</p>
            </div>
          </div>
          <hr style="border-top:5px solid rgba(0,0,0,0.4);">
          <div class="row">
            <div class="col-md-12">
              <p style="font-size: 20px;"><b>Kepada Yth.</b></p>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <p style="font-size: 20px;">
                <b>Nama</b><span style="display:inline-block; width:40px;"></span>{!! $pembelian->supplier->nama !!}<span style="display:block;"></span>
                <b>No. Telp</b><span style="display:inline-block; width:20px;"></span>{!! $pembelian->supplier->telepon == null ? "-" : $pembelian->supplier->telepon !!}<span style="display:block;"></span>
                <b>Alamat</b><span style="display:inline-block; width:30px;"></span>{!! $pembelian->supplier->alamat == null ? "-" : $pembelian->supplier->alamat !!}<span style="display:block;"></span>
              </p>
            </div>
            <div class="col-md-4 ml-auto">
              <p style="font-size: 20px;">
                <b>No. Invoice</b><span style="display:inline-block; width:20px;"></span>{!! $pembelian->no_faktur !!}<span style="display:block;"></span>
                <b>Tanggal</b><span style="display:inline-block; width:50px;"></span>{!! date_format(date_create($pembelian->tanggal), "d M Y") !!}<span style="display:block;"></span>
                <b>Pembayaran</b><span style="display:inline-block; width:10px;"></span>{!! $pembelian->tanggal_due !!}<span style="display:block;"></span>
              </p>
            </div>
          </div>

          <div class="row" style="margin-top: 3rem;">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead class="text-primary text-center">
                    <tr>
                      <th style="width:15%;">Qty</th>
                      <th style="width:45%;">Nama Barang</th>
                      <th style="width:20%;">Harga Unit</th>
                      <th style="width:20%;">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $total = 0;
                    @endphp
                    @foreach($pembelian->barangs()->withTrashed()->get() as $b)
                    <tr>
                      <td class="text-center">{!! number_format($b->pivot->quantity,0,",",".") !!}</td>
                      <td>{!! $b->nama !!}</td>
                      <td class="text-right">Rp{!! number_format($b->pivot->hbeli,2,",",".") !!}</td>
                      <td class="text-right">Rp{!! number_format($b->pivot->quantity * $b->pivot->hbeli,2,",",".") !!}</td>
                      @php
                        $total += $b->pivot->quantity * $b->pivot->hbeli;
                      @endphp
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot class="text-primary text-right">
                    <tr>
                      <td colspan="2"></td>
                      <td>Total</td>
                      <td>Rp{!! number_format($total,2,",",".") !!}</td>
                    </tr>
                  </tfoot>
                </table>
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
		$('#nav_penjualan').addClass('active');
    $('#nav_transaksi').addClass('active');
	});
</script>
@endsection