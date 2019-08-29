<html>
	<head id="head">
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

      	<style>
	    	@page {
	    		size: 9.5in 5.5in;
	    		margin: 20px;
	    	}
	    	@media print {
	    		@page {
	    			size: 9.5in 5.5in;
	    			margin: 20px;
	    		}
	    	}
	    </style>
	</head>
	<body id="body">
		<p class="" style="font-size: 24px;">
			<b>Sripuja Elektronik</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			<b>INVOICE</b><br>
			Jl. Danau Buyan no. 12, Negara, Bali<br>
			Telp. (0365) 41713 / 081999919001
		</p>
		<hr style="border-top:5px solid rgba(0,0,0,0.4);">
		<b style="font-size: 20px;">Kepada Yth.</b><br>

		<table class="table-borderless">
			<tr>
				<td width="75%"><b>Nama</b><span style="display:inline-block; width:40px;"></span>{!! $penjualan->customer->nama !!}</td>
				<td><b>No. Invoice</b><span style="display:inline-block; width:20px;"></span>{!! $penjualan->no_faktur !!}</td>
			</tr>
			<tr>
				<td><b>No. Telp</b><span style="display:inline-block; width:20px;"></span>{!! $penjualan->customer->telepon == null ? "-" : $penjualan->customer->telepon !!}<span style="display:block;"></span></td>
				<td><b>Tanggal</b><span style="display:inline-block; width:43px;"></span>{!! date_format(date_create($penjualan->tanggal), "d/m/Y") !!}<span style="display:block;"></span></td>
			</tr>
			<tr>
				<td><b>Alamat</b><span style="display:inline-block; width:30px;"></span>{!! $penjualan->customer->alamat == null ? "-" : $penjualan->customer->alamat !!}<span style="display:block;"></span></td>
				<td><b>Pembayaran</b><span style="display:inline-block; width:10px;"></span>{!! date_format(date_create($penjualan->tanggal), "d/m/Y") !!}<span style="display:block;"></span></td>
			</tr>
		</table>
		<br>
		<div>
			<table class="table table-condensed table-bordered">
				<thead class="text-primary text-center">
					<tr>
						<th style="width:5%;">Kwt</th>
						<th style="width:55%;">Nama Barang</th>
						<th style="width:20%;">Harga Unit</th>
						<th style="width:20%;">Total</th>
					</tr>
				</thead>
				<tbody id="printedData">
					@php
						$total = 0;
					@endphp
					@foreach($penjualan->barangs()->withTrashed()->get() as $b)
					<tr>
						<td class="text-center">{!! number_format($b->pivot->quantity,0,",",".") !!}</td>
						<td class="text-left" style="padding-left: 10px;">{!! $b->nama !!}</td>
						<td class="text-right">Rp{!! number_format($b->pivot->hjual,2,",",".") !!}</td>
						<td class="text-right">Rp{!! number_format($b->pivot->quantity * $b->pivot->hjual,2,",",".") !!}</td>
						@php
							$total += $b->pivot->quantity * $b->pivot->hjual;
						@endphp
					</tr>
					@endforeach
				</tbody>
				<tfoot class="text-primary text-right">
					<tr>
						<td colspan="2"></td>
						<td class="text-right">Grand Total</td>
						<td class="text-right">Rp{!! number_format($total,2,",",".") !!}</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</body>

	<script src="{{asset('assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			window.print();
			// var htmlOpen = "<html><head>";
   //          var head = '<link href="/assets/css/material-dashboard.css?v=2.1.0" rel="stylesheet"></head><body>';
		
   //          var body = "<div class='content'>" +
   //          				"<div class='container-fluid'>" +
   //          					"<div class='row'>" +
			// 						"<div class='col-md-1'></div>" +
			// 						"<div class='col-md-6'>" +
			// 							"<p class='' style='font-size: 24px;''>" +
			// 								"<b>Sripuja Elektronik</b><br>" +
			// 								"Jl. Danau Buyan no. 12, Negara, Bali<br>" +
			// 								"Telp. (0365) 41713 - 081999919001" +
			// 							"</p>" +
			// 						"</div>" +
			// 						"<div class='col-md-3 ml-auto'>" +
			// 							"<p class='text-primary' style='font-size: 24px;'>INVOICE</p>" +
			// 						"</div>" +
			// 					"</div></div></div>";


   //          var htmlClose = "</body></html>";

   //          var a = window.open('', '', 'height=528, width=912'); 
   //          a.document.write(htmlOpen); 
   //          a.document.write(head); 
   //          a.document.write(body); 
   //          a.document.write(htmlClose);
   //          a.print();
   //          window.close()
		});
	</script>

</html>