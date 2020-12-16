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
          <th style="width: 5%; border-right: 1px solid #000; border-bottom: 1px solid #000;">Kategori</th>         
          <th style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;">Qty</th>
          <th style="width: 15%; border-right: 1px solid #000; border-bottom: 1px solid #000;">Nama</th>
          <th style="width: 15%; border-right: 1px solid #000; border-bottom: 1px solid #000;">HPP</th>
          <th style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;">H.Jual</th>
        </tr>
      </thead>
      <tbody>
        @php
          $prev = "";
        @endphp
        @foreach($sales as $s)
          <tr>
            <td style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;">{!! $prev == $s->category ? "" : $s->category !!}</td>         
            <td style="width: 5%; border-right: 1px solid #000; border-bottom: 1px solid #000;">{!! $s->quantity !!}</td>         
            <td style="width: 20%; border-right: 1px solid #000; border-bottom: 1px solid #000;">{!! $s->nama !!}</td>         
            <td style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;">{!! number_format($s->hbeli, 0, '.', '.') !!}</td>         
            <td style="width: 10%; border-right: 1px solid #000; border-bottom: 1px solid #000;">{!! number_format($s->hjual, 0, '.', '.') !!}</td>         
          </tr>
          @php
            $prev = $s->category;
          @endphp
        @endforeach
      </tbody>
      <tfoot>
      </tfoot>
    </table>
  </main>
  <footer>

  </footer>
</body>
</html>