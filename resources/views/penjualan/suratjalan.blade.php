<html>
	<head>
	  <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-table.css')}}">

	  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
	  <link rel="icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	  <meta name="csrf-token" content="{{ csrf_token() }}">
	  <title>
	    Sripuja
	  </title>
	  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	  <!--     Fonts and icons     -->
	  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	  <!-- CSS Files -->
	  <link href="{{asset('assets/css/material-dashboard.css?v=2.1.0')}}" rel="stylesheet" />
	  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/selectize.default.css')}}">
	</head>
	<body>
		<div class="wrapper">
			<div class="main-panel">
				<div class="content">
					<div class="container-fluid">
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
								<p class="text-primary" style="font-size: 24px;">INVOICE</p>
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
									<b>Nama</b><span style="display:inline-block; width:40px;"></span>{!! $penjualan->customer->nama !!}<span style="display:block;"></span>
									<b>No. Telp</b><span style="display:inline-block; width:20px;"></span>{!! $penjualan->customer->telepon == null ? "-" : $penjualan->customer->telepon !!}<span style="display:block;"></span>
									<b>Alamat</b><span style="display:inline-block; width:30px;"></span>{!! $penjualan->customer->alamat == null ? "-" : $penjualan->customer->alamat !!}<span style="display:block;"></span>
								</p>
							</div>
							<div class="col-md-4 ml-auto">
								<p style="font-size: 20px;">
									<b>No. Invoice</b><span style="display:inline-block; width:20px;"></span>{!! $penjualan->no_faktur !!}<span style="display:block;"></span>
									<b>Tanggal</b><span style="display:inline-block; width:50px;"></span>{!! date_format(date_create($penjualan->tanggal), "d M Y") !!}<span style="display:block;"></span>
									<b>Pembayaran</b><span style="display:inline-block; width:10px;"></span>{!! $penjualan->tanggal !!}<span style="display:block;"></span>
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
											</tr>
										</thead>
										<tbody>
											@php
												$total = 0;
											@endphp
											@foreach($penjualan->barangs()->withTrashed()->get() as $b)
											<tr>
												<td class="text-center">{!! number_format($b->pivot->quantity,0,",",".") !!}</td>
												<td>{!! $b->nama !!}</td>
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

	<script src="{{asset('assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			window.print();
			window.close();
		});
	</script>
	</body>
</html>