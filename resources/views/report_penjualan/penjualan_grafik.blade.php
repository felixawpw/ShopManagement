@extends('layouts.master')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
		  <div class="card ">
		    <div class="card-header card-header-primary">
		      <h4 class="card-title">Grafik Laba Penjualan 
		        <small class="description">{!! $formattedTanggalAwal !!} - {!! $formattedTanggalAkhir !!}</small>
		      </h4>
		    </div>
		    <div class="card-body">
		    	<div class="row">
		    		<div class="col-md-12">
	                  <div id="penjualan_harian_chart" class="ct-chart"></div>  
		    		</div>
		    	</div>
		    </div>
		    <div class="class-footer">
		    </div>
		  </div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
		  <div class="card ">
		    <div class="card-header card-header-primary">
		      <h4 class="card-title">Penjualan Berdasarkan Kategori
		        <small class="description">{!! $formattedTanggalAwal !!} - {!! $formattedTanggalAkhir !!}</small>
		      </h4>
		    </div>
		    <div class="card-body">
		    	<div class="row">
		    		<div class="col-md-6">
		    			<div class="card">
		    				<div class="card-header card-header-success">
							    <h4 class="card-title">Penjualan per Merk
							        <small class="description"></small>
							    </h4>
		    				</div>
		    				<div class="card-body">
		    					<div class="row">
		    						<div class="col-md-12">
							          <div class="material-datatables">
							            <table id="table_brand" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
							              <thead>
							                <tr>
							                  <th>Brand</th>
							                  <th>Jumlah Penjualan</th>
  							                  <th>Omset</th>
							                  <th>Prosentase</th>
							                </tr>
							              </thead>
							              <tbody>
							                @foreach($resultBrand as $key=>$value)
							                  <tr>
							                  	<td>{!! $key !!}</td>
							                  	<td>{!! $value !!}</td>
							                  	<td>{!! number_format($resultBrandOmset[$key], 0, '.', ',') !!}</td>
							                  	<td>{!! number_format($resultBrandOmset[$key]/$totalOmset * 100, 2, ',', '.')."%" !!}</td>
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
		    		<div class="col-md-6">
		    			<div class="card">
		    				<div class="card-header card-header-success">
							    <h4 class="card-title">Penjualan per Jenis Barang
							        <small class="description"></small>
							    </h4>
		    				</div>
		    				<div class="card-body">
		    					<div class="row">
		    						<div class="col-md-12">
							          <div class="material-datatables">
							            <table id="table_tipe_barang" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
							              <thead>
							                <tr>
							                  <th>Tipe Barang</th>
							                  <th>Jumlah Penjualan</th>
							                  <th>Prosentase</th>
							                  <th>Omset</th>
							                </tr>
							              </thead>
							              <tbody>
							                @foreach($resultTipeBarang as $key=>$value)
							                  <tr>
							                  	<td>{!! $key !!}</td>
							                  	<td>{!! $value !!}</td>
							                  	<td>{!! number_format($resultTipeBarangOmset[$key], 0, '.', ',') !!}</td>
							                  	<td>{!! number_format($resultTipeBarangOmset[$key]/$totalOmset * 100, 2, ',', '.')."%" !!}</td>
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
		    </div>
		    <div class="class-footer">
		    </div>
		  </div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
	    $('#nav_report').addClass('active');
	    $('#nav_report_1').addClass('active');
	});

	function loadChart(result1, result2, chartId) {
	    var labels = [];
        
        var r1 = [];
        var r2 = [];
        for (key in result1) {
          labels.push(key.split("-")[2]);
          r1.push(result1[key]);
          r2.push(result2[key]);
        }

        var series = [r1, r2];
        console.log(series);
	    var data = {
	      // A labels array that can contain any sort of values
	      labels: labels,
	      // Our series array that contains series objects or in this case series data arrays
	      series: series
	    };

	    var options = {
	      plugins: [
	        Chartist.plugins.tooltip()
	      ],
	      height: '500px'
	    };
	    // Create a new line chart object where as first parameter we pass in a selector
	    // that is resolving to our chart container element. The Second parameter
	    // is the actual data object.
	    new Chartist.Line(chartId, data, options);

	}

	function loadPieChart(result, chartId) {
		var labels = [];
		var series = [];

		for(key in result) {
			labels.push(key);
			series.push(result[key]);
		}

		var data = {
			labels: labels,
			series: [series]	
		};

		var options = {
		  labelInterpolationFnc: function(value) {
	        return Math.round(value / data.series.reduce(sum) * 100) + '%';
		  },
		  height: '400px',
	      plugins: [
	        Chartist.plugins.tooltip()
	      ],

		};

		var responsiveOptions = [
		  ['screen and (min-width: 640px)', {
		    chartPadding: 30,
		    labelOffset: 100,
		    labelDirection: 'explode',
		    labelInterpolationFnc: function(value) {
		      return value;
		    }
		  }],
		  ['screen and (min-width: 1024px)', {
		    labelOffset: 80,
		    chartPadding: 20,
		  }]
		];

		new Chartist.Pie(chartId, data, options, responsiveOptions);
	}

	$(document).ready(function(){
		loadChart(JSON.parse('{!! json_encode($resultLaba) !!}'), JSON.parse('{!! json_encode($resultOmset) !!}'), "#penjualan_harian_chart");
		$("#table_brand").DataTable({
			"searching": false,   // Search Box will Be Disabled
			"ordering": true,    // Ordering (Sorting on Each Column)will Be Disabled
			"info": false,         // Will show "1 to n of n entries" Text at bottom
  		"lengthChange": false
		});
		$("#table_tipe_barang").DataTable({
			"searching": false,   // Search Box will Be Disabled
			"ordering": true,    // Ordering (Sorting on Each Column)will Be Disabled
			"info": false,         // Will show "1 to n of n entries" Text at bottom
  		"lengthChange": false
		});

	});

</script>
@endsection