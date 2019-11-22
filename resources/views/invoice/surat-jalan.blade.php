<!DOCTYPE html>
<html>
<head>
	<title>Printing Invoice</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<style type="text/css">
        @page {
        	margin-top: 140px;
        	margin-bottom: 100px;
        }

        header {
            position: fixed;
            top: -140px;
            left: 0px;
            right: 0px;
            height: 300px;
        }
        footer {
        	position: fixed;
        	bottom: -1px;
        	left: 0px; 
        	right: 0px;
        	height: 50px;
        }
        .page-number:after { content: counter(page); }
        .page_break { page-break-before: always; }

	</style>
</head>
<body>
	<header>
		<table class="table table-borderless table-sm" style="margin-bottom: 0px;">
			<tr>
				<td style="font-size: 12px;">
					<B style="font-size: 24px;"><u>SURAT JALAN</u></B><br>
					<B style="font-size: 18px;">Sripuja Elektronik</B><br>
					Jl. Danau Buyan No.12, Negara, Bali<br>
					(0365) 41713 / 081 9999 19 001<br>
				</td>
				<td>
					<table class="table table-borderless table-sm" style="font-size: 12px; margin-bottom: 0px;">
						<tr class="text-center">
							<td>
								<table style="width: 150px; border: 1px solid #000;">
									<thead style="border-bottom: 1px solid #000;">
										<tr>
											<th>UNTUK NO.INVOICE</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>{!! $penjualan->no_faktur!!}</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</table>
				</td>

				<td style="font-size: 12px; width: 325px;" >
					Negara, {!! date_format(date_create($penjualan->tanggal), "d M Y") !!}<br>
					<table class="table-sm" style="border: 1px solid #000; width: 100%;">
						<thead style="border: 1px solid #000;">
							<tr class="text-center">
								<td>Customer</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									{!! $penjualan->customer->nama !!}<br>
									{!! $penjualan->customer->alamat != null ? $penjualan->customer->alamat : "-" !!}<br>
									{!! $penjualan->customer->telepon != null ? $penjualan->customer->telepon : "-" !!}
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
	</header>

	<main>
		@php
			$brgs = $penjualan->barangs()->withTrashed()->get();
			$ul = $brgs->count();
			$iteration = (int) ($ul / 11);
			$total = 0;
			$discount = 0;
		@endphp
		@for($i = 0; $i < $iteration; $i++)
			<table class="" style="font-size: 12px; width: 100%; margin-bottom: 10px;">
				<thead class="text-center" style="border: 1px solid #000000;">
					<tr>
						<th style="width: 5%; border-right: 1px solid #000000;">QTY</th>
						<th style="width: 35%; border-right: 1px solid #000000;">Nama Barang</th>
						<th style="width: 35%; border-right: 1px solid #000000;">Keterangan</th>
					</tr>
				</thead>
				<tbody class="table-sm" style="border: 1px solid #000000; page-break-after: always;">
					@for($j = 0; $j < 11; $j++)
						@if (isset($brgs[($i * 11) + $j]))
							@php
								$b = $brgs[($i * 11) + $j];
							@endphp

							<tr>
								<td style="border-right: 1px solid #000000;" class="text-center">{!! number_format($b->pivot->quantity,0,",",".") !!}</td>
								<td style="border-right: 1px solid #000000;">{!! $b->nama !!}</td>
								<td style="border-right: 1px solid #000000;">{!! $b->keterangan !!}</td>
								@php
									$total += $b->pivot->quantity * $b->pivot->hjual;
									$discount += $b->pivot->discount * $b->pivot->quantity;
								@endphp
							</tr>
						@else
							<tr class="text-right">
								<td style="border-right: 1px solid #000000;">-</td>
								<td style="border-right: 1px solid #000000;"></td>
								<td style="border-right: 1px solid #000000;"></td>
							</tr>
						@endif
					@endfor
				</tbody>
				<tfoot>
				</tfoot>
			</table>
			<footer>
				<table style="width: 100%; font-size: 12px; margin-bottom: 75px;">
					<tbody>
						<tr style="margin-top: 10px;" class="text-center">
							<td style="padding-top: 10px;">
								MENGETAHUI
							</td>
							<td style="padding-top: 10px;">
								PENGANTAR
							</td>
							<td style="padding-top: 10px;">
								PENERIMA
							</td>
						</tr>
					</tbody>
				</table>

				<table style="width: 100%;" class="text-center">
					<tbody>
						<tr>
							<td style="font-size: 12px; font-style: italic; bottom: 10px;">Page<span class="page-number">&nbsp;</span> of {!! ($iteration + 1) !!}</td>
						</tr>
					</tbody>
				</table>
			</footer>


			<div class="page_break"></div>
		@endfor

		<table class="" style="font-size: 12px; width: 100%; margin-bottom: 10px;">
			<thead class="text-center" style="border: 1px solid #000000;">
				<tr>
					<th style="width: 5%; border-right: 1px solid #000000;">QTY</th>
					<th style="width: 35%; border-right: 1px solid #000000;">Nama Barang</th>
					<th style="width: 35%; border-right: 1px solid #000000;">Keterangan</th>
				</tr>
			</thead>
			<tbody class="table-sm" style="border: 1px solid #000000; page-break-after: always;">
				@for($j = 0; $j < 11; $j++)
					@if (isset($brgs[($i * 11) + $j]))
						@php
							$b = $brgs[($i * 11) + $j];
						@endphp

						<tr>
							<td style="border-right: 1px solid #000000;" class="text-center">{!! number_format($b->pivot->quantity,0,",",".") !!}</td>
							<td style="border-right: 1px solid #000000;">{!! $b->nama !!}</td>
							<td style="border-right: 1px solid #000000;">{!! $b->keterangan !!}</td>
							@php
								$total += $b->pivot->quantity * $b->pivot->hjual;
								$discount += $b->pivot->discount * $b->pivot->quantity;
							@endphp
						</tr>
					@else
						<tr class="text-right">
							<td style="border-right: 1px solid #000000;">-</td>
							<td style="border-right: 1px solid #000000;"></td>
							<td style="border-right: 1px solid #000000;"></td>
						</tr>
					@endif
				@endfor
			</tbody>

			<tfoot>
			</tfoot>
		</table>
	</main>
	<footer>
		<table style="width: 100%; font-size: 12px; margin-bottom: 75px;">
			<tbody>
				<tr style="margin-top: 10px;" class="text-center">
					<td style="padding-top: 10px;">
						MENGETAHUI
					</td>
					<td style="padding-top: 10px;">
						PENGANTAR
					</td>
					<td style="padding-top: 10px;">
						PENERIMA
					</td>
				</tr>
			</tbody>
		</table>

		<table style="width: 100%;" class="text-center">
			<tbody>
				<tr>
					<td style="font-size: 12px; font-style: italic; bottom: 10px;">Page<span class="page-number">&nbsp;</span> of {!! ($iteration + 1) !!}</td>
				</tr>
			</tbody>
		</table>
	</footer>
</body>
</html>