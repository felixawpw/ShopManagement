@extends('layouts.master')

@section('content')
<div class="container-fluid">
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
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
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