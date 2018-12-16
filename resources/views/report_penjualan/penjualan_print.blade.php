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
              <div class="col-md-6 ml-auto mr-auto text-center">
                <h3>Laporan Penjualan Periode<br>{!! $formattedTanggalAwal !!} - {!! $formattedTanggalAkhir !!}</h3>
              </div>
            </div>
            <div class="row" style="margin-top: 3rem;">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead class="text-primary text-center">
                      <tr>
                        <th style="width: 5%;">Tanggal</th>
                        <th style="width: 25%;">Nomor Nota</th>
                        <th style="width: 30%;">Pelanggan</th>
                        <th style="width: 20%;">Total Penjualan</th>
                        <th>Laba</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $totalPenjualan = 0;
                        $totalLaba = 0;
                      @endphp
                      @foreach($penjualans as $p)
                        <tr>
                          <td class="text-center">{!! $p->tanggal !!}</td>
                          <td class="text-left">{!! $p->no_nota !!}</td>
                          <td class="text-left">{!! $p->customer->nama !!}</td>
                          <td class="text-right">{!! $p->totalText !!}</td>
                          <td class="text-right">{!! $p->labaText !!}</td>
                        </tr>

                        @php
                          $totalPenjualan += $p->total;
                          $totalLaba += $p->laba;
                        @endphp
                      @endforeach
                    </tbody>
                    <tfoot class="text-primary text-right">
                      <tr>
                        <td colspan="3">Total</td>
                        <td><b>{!! number_format($totalPenjualan, 2, '.', '.') !!}</b></td>
                        <td><b>{!! number_format($totalLaba, 2, '.', '.') !!}</b></td>
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

  <script src="{{asset('assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      window.print();
      window.close();
    });
  </script>
  </body>
</html>