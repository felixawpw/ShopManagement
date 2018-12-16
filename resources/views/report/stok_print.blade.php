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
                <h3>Laporan Stok Barang Bulan<br>{!! $periode !!}</h3>
              </div>
            </div>
            <div class="row" style="margin-top: 3rem;">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead class="text-primary text-center">
                      <tr>
                        <th style="width: 40%;">Nama Barang</th>
                        <th style="width: 20%;">Penjualan</th>
                        <th style="width: 20%;">Pembelian</th>
                        <th style="width: 10%;">Jumlah stok</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($barangs as $b)
                      <tr>
                        <th>{!! $b->nama !!}</th>
                        <th>{!! $b->terjual !!}</th>
                        <th>{!! $b->masuk !!}</th>
                        <th>{!! $b->stoktotal !!}</th>
                      </tr>
                      @endforeach
                    </tbody>
<!--                     <tfoot class="text-primary text-right">
                      <tr>
                        <td colspan="4">Total</td>
                      </tr>
                    </tfoot>
 -->                  </table>
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