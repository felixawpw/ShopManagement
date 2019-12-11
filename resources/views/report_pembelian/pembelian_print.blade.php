<!DOCTYPE html>
<html>
<head>
  <title>Printing Laporan Pembelian</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style type="text/css">
        @page {
          margin-top: 100px;
        }

        header {
            position: fixed;
            top: -100px;
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
        .text-center {
          text-align: center;
        }

        .text-right {
          text-align:right;
        }

  </style>
</head>
<body style="font-size: medium;">
  <header>
    <h3 class="text-center">Laporan Pembelian Periode<br>{!! $formattedTanggalAwal !!} - {!! $formattedTanggalAkhir !!}</h3>
  </header>
  <main>
    <table style="width: 100%; border-top: 1px solid #000; border-left: 1px solid #000;">
      <thead class="text-center">
        <tr>
          <th style="width: 5%; border-right: 1px solid #000; border-bottom: 1px solid #000;">No.</th>         
          <th style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;">Tanggal</th>
          <th style="width: 15%; border-right: 1px solid #000; border-bottom: 1px solid #000;">Nomor Nota</th>
          <th style="width: 15%; border-right: 1px solid #000; border-bottom: 1px solid #000;">Supplier</th>
          <th style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;">Jatuh Tempo</th>
          <th style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;">Total Pembelian</th>
        </tr>
      </thead>
      <tbody>
        @php
          $no = 1;
          $totalPembelian = 0;
        @endphp

        @foreach($pembelians as $p)
          <tr>
            <td style="width: 5%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-center">{!! $no++ !!}</td>
            <td style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-center">{!! $p->tanggal !!}</td>
            <td style="width: 15%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-left">{!! $p->no_nota !!}</td>
            <td style="width: 15%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-left">{!! $p->supplier->nama !!}</td>
            <td style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-center">{!! date_format(date_create($p->tanggal_due), "d/m/Y") !!}</td>
            <td style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-right">{!! number_format($p->total, 2, ',', '.') !!}</td>
          </tr>

          @php
            $totalPembelian += $p->total;
          @endphp
        @endforeach

      </tbody>
      <tfoot>
        <tr>
          <td colspan="4" style="border-right: 1px solid #000; border-bottom: 1px solid #000;">&nbsp;</td>
          <td style="width: 20%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-right"><b>Total</b></td>
          <td style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-right"><b>{!! number_format($totalPembelian, 2, ',', '.') !!}</b></td>
        </tr>
      </tfoot>
    </table>
  </main>
  <footer>

  </footer>
</body>
</html>