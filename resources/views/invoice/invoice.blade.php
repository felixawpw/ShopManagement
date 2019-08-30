<!DOCTYPE html>
<html>
<head>
	<title>Printing Invoice</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
	<table class="table table-borderless table-sm">
		<tr>
			<td>
				<b style="font-size: 24px;">Sripuja Elektronik</b><br>
				Jl. Danau Buyan no. 12, Negara, Bali<br>
				Telp. (0365) 41713 / 081999919001
			</td>
			<td style="font-size: 24px; padding-right: 24px;" class="text-right"><b>Invoice</b></td>
		</tr>
	</table>
	<hr style="border-top:3px solid rgba(0,0,0,1);">

	<table class="table table-borderless table-sm">
		<tr>
			<td colspan=4>
				Kepada Yth.
			</td>
		</tr>
		<tr>
			<td style="width: 10%;">
				Nama<br>
				No. Telp<br>
				Alamat
			</td>
			<td style="width: 60%;">
				{!! $penjualan->customer->nama !!}<br>
				{!! $penjualan->customer->telepon !!}<br>
				{!! $penjualan->customer->alamat !!}
			</td>
			<td style="width: 15%;">
				No. Invoice<br>
				Tgl. Invoice<br>
				Tgl. Pembayaran
			</td>
			<td style="width: 15%;">
				{!! $penjualan->no_faktur !!}<br>
				{!! date_format(date_create($penjualan->tanggal), "d M Y") !!}<br>
				{!! date_format(date_create($penjualan->tanggal), "d M Y") !!}
			</td>
		</tr>
	</table>

	<table class="table">
		<thead class="text-center">
			<tr>
				<th>Kwt</th>
				<th>Nama Barang</th>
				<th>Harga Unit</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody class="table-sm">
			@php
				$total = 0;
			@endphp
			@foreach($penjualan->barangs()->withTrashed()->get() as $b)
			<tr>
				<td class="text-center">{!! number_format($b->pivot->quantity,0,",",".") !!}</td>
				<td>{!! $b->nama !!}</td>
				<td class="text-right">Rp{!! number_format($b->pivot->hjual,2,",",".") !!}</td>
				<td class="text-right">Rp{!! number_format($b->pivot->quantity * $b->pivot->hjual,2,",",".") !!}</td>
				@php
					$total += $b->pivot->quantity * $b->pivot->hjual;
				@endphp
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<td class="text-right" colspan="3"><b>Grand Total</b></td>
				<td class="text-right">Rp{!! number_format($total,2,",",".") !!}</td>
			</tr>
		</tfoot>
	</table>
</body>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"/>

</html>
<!--
				<table class="table table-sm">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">First</th>
			      <th scope="col">Last</th>
			      <th scope="col">Handle</th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
			      <th scope="row">1</th>
			      <td>Mark</td>
			      <td>Otto</td>
			      <td>@mdo</td>
			    </tr>
			    <tr>
			      <th scope="row">2</th>
			      <td>Jacob</td>
			      <td>Thornton</td>
			      <td>@fat</td>
			    </tr>
			    <tr>
			      <th scope="row">3</th>
			      <td colspan="2">Larry the Bird</td>
			      <td>@twitter</td>
			    </tr>
			  </tbody>
			</table>

-->