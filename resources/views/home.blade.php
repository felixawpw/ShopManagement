@extends('layouts.master')

@section('content')
<div class="container-fluid">
	<!-- Daily Reports -->
	<div class="row">
		<div class="col-md-6">
		  <div class="card ">
		    <div class="card-header card-header-primary">
		      <h4 class="card-title">Daily Income Report
		        <small class="description"></small>
		      </h4>
		    </div>
		    <div class="card-body">
		    	<div class="row">
		    		<div class="col-md-6 mr-auto text-center">
					      <div class="card ">
					        <div class="card-header card-header-success">
					          <h4 class="card-title">Total Sales
					            <small class="description"></small>
					          </h4>
					        </div>
					        <div class="card-body">
			        			<p style="font-size: 24px;">Rp. {!! number_format($dialyReport['income'],2,",",".") !!}</p>
					        </div>
					      </div>
					    </div>
		    		<div class="col-md-6 mr-auto text-center">
				      <div class="card ">
				        <div class="card-header card-header-success">
				          <h4 class="card-title">Profit
				            <small class="description"></small>
				          </h4>
				        </div>
				        <div class="card-body">
		        			<p style="font-size: 24px;">Rp. {!! number_format($dialyReport['profit'],2,",",".") !!} </p>
				        </div>
				      </div>
				    </div>
		    	</div>
		    </div>
		    <div class="class-footer">
		    </div>
		  </div>
		</div>
		<div class="col-md-6">
		  <div class="card ">
		    <div class="card-header card-header-primary">
		      <h4 class="card-title">Daily Inventory Report
		        <small class="description"></small>
		      </h4>
		    </div>
		    <div class="card-body">
		      <div class="row">
		          <div class="col-md-4">
		            <ul class="nav nav-pills nav-pills-primary flex-column" role="tablist">
		              <li class="nav-item">
		                <a class="nav-link active" data-toggle="tab" href="#nav_pills_name" role="tablist">
		                  By Name
		                </a>
		              </li>
		              <li class="nav-item">
		                <a class="nav-link" data-toggle="tab" href="#nav_pills_category" role="tablist">
		                  By Category
		                </a>
		              </li>
		              <li class="nav-item">
		                <a class="nav-link" data-toggle="tab" href="#nav_pills_brand" role="tablist">
		                  By Brand
		                </a>
		              </li>
		            </ul>
		          </div>
		          <div class="col-md-8">
		            <div class="tab-content">
		              <div class="tab-pane active" id="nav_pills_name">
			          	<div class="material-datatables">
				            <table id="table_dialy_inventory_name" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
				          	  <thead>
				                <tr>
				                  <th>Nama</th>
				                  <th>Jumlah</th>
				                </tr>
				              </thead>
				              <tbody>
				              	@foreach($dialyReport["barangs"] as $b)
				              		<tr>
				              			<td>{!! $b["nama"] !!}</td>
					              		<td>{!! $b["sum"] !!}</td>
				              		</tr>
				              	@endforeach
				              </tbody>
				            </table>
			              </div>
			            </div>
		              <div class="tab-pane" id="nav_pills_category">
			          	<div class="material-datatables">
					            <table id="table_dialy_inventory_category" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
					          	  <thead>
					                <tr>
					                  <th>Nama</th>
					                  <th>Jumlah</th>
					                </tr>
					              </thead>
					              <tbody>
					              	@foreach($dialyReport["categories"] as $b)
					              		<tr>
					              			<td>{!! $b["nama"] !!}</td>
						              		<td>{!! $b["sum"] !!}</td>
					              		</tr>
					              	@endforeach
					              </tbody>
					            </table>
			              </div>
		              </div>
		              <div class="tab-pane" id="nav_pills_brand">
		         			<div class="material-datatables">
					            <table id="table_dialy_inventory_brand" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
					          	  <thead>
					                <tr>
					                  <th>Nama</th>
					                  <th>Jumlah</th>
					                </tr>
					              </thead>
					              <tbody>
					              	@foreach($dialyReport["brands"] as $b)
					              		<tr>
					              			<td>{!! $b["nama"] !!}</td>
						              		<td>{!! $b["sum"] !!}</td>
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
		  <div class="class-footer">
		  </div>
		</div>
	</div>

	<!--  -->
	<div class="row">
		<div class="col-md-12">
		  <div class="card">
		    <div class="card-header card-header-primary">
		      <div class="row">
		        <div class="col-md-auto">
		          <h4 class="card-title ">Due Date BG/Credits</h4>
		        </div>
		      </div>
		    </div>
		    <div class="card-body">
		      <div class="toolbar">
		        <!--        Here you can write extra buttons/actions for the toolbar              -->
		      </div>
		      <ul class="nav nav-pills nav-pills-warning" role="tablist">
		        <li class="nav-item">
		          <a class="nav-link active" data-toggle="tab" href="#tab_calendar" role="tablist">
		            Calendar
		          </a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" data-toggle="tab" href="#tab_table" role="tablist">
		            Table View
		          </a>
		        </li>
		      </ul>

		      <div class="tab-content tab-space">
		        <div class="tab-pane active" id="tab_calendar">
		          <div class="row">
		            <div class="col-md-9 ml-auto mr-auto">
		              <div id="calendar"></div>
		            </div>
		          </div>
		        </div>
		        <div class="tab-pane" id="tab_table">
		          <div class="material-datatables">
		            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
		              <thead>
		                <tr>
		                  <th>Nomor Nota</th>
		                  <th>Supplier</th>
		                  <th>Tanggal Pembelian</th>
		                  <th>Tanggal Jatuh Tempo</th>
		                  <th>Total</th>
		                </tr>
		              </thead>
		              <tbody>
		                @foreach($hutangs as $h)
		                  <tr>
		                  	<td>{!! $h->no_nota !!}</td>
		                  	<td>{!! $h->supplier->nama !!}</td>
		                  	<td>{!! $h->tanggal !!}</td>
		                  	<td>{!! $h->tanggal_due !!}</td>
		                  	<td>{!! $h->total !!}</td>
		                  </tr>
		                @endforeach
		              </tbody>
		            </table>
		          </div>
		        </div>
		      </div>
		    </div>
		    <!-- end content-->
		  </div>
		  <!--  end card  -->
		</div>
	<!-- end col-md-12 -->
	</div>

</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$('#dashboard').addClass('active');

	    $('#calendar').fullCalendar({
	      events: [
	        @foreach($hutangs as $h)
	        {
						url: "{!! route('pembelian.edit', $h->id) !!}",
						tooltipext: " (Click to edit)",
	          title: "{!! $h->supplier->nama !!} - {!! $h->no_nota !!}",
	          start: "{!! $h->tanggal_due !!}",
	          @php
	            $date = new DateTime("$h->tanggal_due");
	            $date->modify("+1 day");
	          @endphp
	          end: "{!! $date->format('Y-m-d') !!}",
	        },
	        @endforeach
	      ],
	      defaultView: 'month',
	      nextDayThreshold: '00:00:00',
	      header:{ 
	        left: 'month,basicWeek,listWeek',
	        center: 'title',
	        right: 'today prev,next'
	      },
	      eventRender: function(event, element) {
	        $(element).tooltip({title: event.title + (event.tooltipext ? event.tooltipext : "")});             
	      },
	      eventClick: function(event, jsEvent, view) {

	      }
	    });



		$("#table_dialy_inventory_name").DataTable({
			"searching": false,   // Search Box will Be Disabled
			"ordering": true,    // Ordering (Sorting on Each Column)will Be Disabled
			"info": false,         // Will show "1 to n of n entries" Text at bottom
  		"lengthChange": false
		});
		$("#table_dialy_inventory_category").DataTable({
			"searching": false,   // Search Box will Be Disabled
			"ordering": true,    // Ordering (Sorting on Each Column)will Be Disabled
			"info": false,         // Will show "1 to n of n entries" Text at bottom
  		"lengthChange": false
		});
		$("#table_dialy_inventory_brand").DataTable({
			"searching": false,   // Search Box will Be Disabled
			"ordering": true,    // Ordering (Sorting on Each Column)will Be Disabled
			"info": false,         // Will show "1 to n of n entries" Text at bottom
  		"lengthChange": false
		});
	});
</script>
@endsection