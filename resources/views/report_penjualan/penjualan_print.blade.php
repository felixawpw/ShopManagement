<!DOCTYPE html>
<html>
<head>
  <title>Printing Laporan Penjualan</title>
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
    <h3 class="text-center">Laporan Penjualan Periode<br>{!! $formattedTanggalAwal !!} - {!! $formattedTanggalAkhir !!}</h3>
  </header>

  <main>
    <table style="width: 100%; border-top: 1px solid #000; border-left: 1px solid #000;">
      <thead class="text-center">
        <tr>
          <th style="width: 5%; border-right: 1px solid #000; border-bottom: 1px solid #000;">No.</th>         
          <th style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;">Tanggal</th>
          <th style="width: 15%; border-right: 1px solid #000; border-bottom: 1px solid #000;">Nomor Nota</th>
          <th style="width: 15%; border-right: 1px solid #000; border-bottom: 1px solid #000;">Customer</th>
          <th style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;">DPP</th>
          <th style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;">HPP</th>
          <th style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;">Laba Kotor</th>
        </tr>
      </thead>
      <tbody>
        @php
          $no = 1;
          $totalDpp = 0;
          $totalHpp = 0;
          $totalLabaKotor = 0;
        @endphp
        @foreach($penjualans as $p)
          @php
            $totalDpp += $p->dpp;
            $totalHpp += $p->hpp;
            $totalLabaKotor += $p->laba;
          @endphp
          <tr>
            <td style="width: 5%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-center">{!! $no++ !!}</td>
            <td style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-center">{!! $p->tanggal !!}</td>
            <td style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-left">{!! $p->no_nota !!}</td>
            <td style="width: 20%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-left">{!! $p->customer->nama !!}</td>
            <td style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-right">{!! number_format($p->dpp, 2, ',', '.') !!}</td>
            <td style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-right">{!! number_format($p->hpp, 2, ',', '.') !!}</td>
            <td style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-right">{!! number_format($p->laba, 2, ',', '.') !!}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3" style="border-right: 1px solid #000; border-bottom: 1px solid #000;">&nbsp;</td>
          <td style="width: 20%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-right"><b>Total</b></td>
          <td style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-right"><b>{!! number_format($totalDpp, 2, ',', '.') !!}</b></td>
          <td style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-right"><b>{!! number_format($totalHpp, 2, ',', '.') !!}</b></td>
          <td style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="text-right"><b>{!! number_format($totalLabaKotor, 2, ',', '.') !!}</b></td>
        </tr>
      </tfoot>
    </table>
  </main>
  <footer>

  </footer>
</body>
</html>