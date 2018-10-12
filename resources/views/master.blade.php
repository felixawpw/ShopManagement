<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

<!DOCTYPE HTML>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="description" content="Makassar Dental Care">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>Sripuja</title>
		
		<!-- Stylesheet -->
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/css/bootstrap-table.css">
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		<link rel="stylesheet" type="text/css" href="/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="/css/custom.css">
		<link rel="stylesheet" type="text/css" href="/css/fullcalendar.min.css">
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900">
		<link rel="stylesheet" type="text/css" href="/css/selectize.css" />

		<!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}"> -->
		
		<!-- Script -->
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }</script>
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/js/bootstrap-table.js"></script>
		<script type="text/javascript" src="/js/metisMenu.min.js"></script>
		<script type="text/javascript" src="/js/custom.js"></script>
		<script type="text/javascript" src="/js/moment.min.js"></script>
		<script type="text/javascript" src="/js/fullcalendar.min.js"></script>
		<script type="text/javascript" src="/js/selectize.js"></script>
		<script type="text/javascript">
			$.ajaxSetup({
			  headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
			});
		</script>
	</head>
	
	<body>
		<div id="wrapper">
			
			<!-- NAVIGATION -->
			<nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			
				<!-- Header -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					
					<a class="navbar-brand" href="{{route('home')}}">Sripuja</a>
				</div>
				
				<!-- Sidebar -->
				<div class="navbar-default sidebar" role="navigation">
					<div class="sidebar-nav navbar-collapse">
						<ul class="nav" id="side-menu">
							<li>
								<a href="{{route('barang_all')}}"><i class="fa fa-table nav_icon"></i>BARANG<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="{{route('barang_all')}}">Lihat Barang</a>
									</li>
									<li>
										<a href="{{route('barang_create')}}">Tambah Barang Baru</a>
									</li>
								</ul>
							</li>

							<li>
								<a href="{{route('supplier_all')}}"><i class="fa fa-table nav_icon"></i>SUPPLIER<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="{{route('supplier_all')}}">Lihat Supplier</a>
									</li>
									<li>
										<a href="{{route('supplier_create')}}">Tambah Supplier Baru</a>
									</li>
								</ul>
							</li>

							<li>
								<a href="{{route('pegawai_all')}}"><i class="fa fa-table nav_icon"></i>PEGAWAI<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="{{route('pegawai_all')}}">Lihat Pegawai</a>
									</li>
									<li>
										<a href="{{route('pegawai_create')}}">Tambah Pegawai Baru</a>
									</li>
								</ul>
							</li>

							<li>
								<a href="{{route('pembelian_all')}}"><i class="fa fa-table nav_icon"></i>PEMBELIAN<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="{{route('pembelian_all')}}">Lihat Pembelian</a>
									</li>
									<li>
										<a href="{{route('pembelian_create')}}">Tambah Pembelian Baru</a>
									</li>
								</ul>
							</li>

							<li>
								<a href="{{route('penjualan_all')}}"><i class="fa fa-table nav_icon"></i>PENJUALAN<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="{{route('penjualan_all')}}">Lihat Penjualan</a>
									</li>
									<li>
										<a href="{{route('penjualan_create')}}">Tambah Penjualan Baru</a>
									</li>
								</ul>
							</li>
							
							<li>
								<a href="{{route('customer_all')}}"><i class="fa fa-table nav_icon"></i>CUSTOMER<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="{{route('customer_all')}}">Lihat Customer</a>
									</li>
									<li>
										<a href="{{route('customer_create')}}">Tambah Customer Baru</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			
			<!-- PAGE WRAPPER -->
			<div id="page-wrapper">
				<div class="col-md-12 graphs">
					<div class="xs">
						@yield("content")
					</div>
					
					<div class="copy_layout">
						<p>Copyright © 2015 Modern. All Rights Reserved | Design by <a href="http://w3layouts.com/" target="_blank">W3layouts</a></p>
					</div>
				</div>
			</div>
			
		</div>
	</body>
</html>