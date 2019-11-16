@extends('layouts.master')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <div class="row">
            <div class="col-md-auto">
              <h4 class="card-title ">Data Pelanggan</h4>
              <p class="card-category"></p>
            </div>
            <div class="col-md-auto ml-auto">
              <a href="{{route('customer.create')}}">
                <i class="material-icons" style="font-size: 48px; color: lightblue;">add_circle</i>
              </a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="toolbar">
            <!--        Here you can write extra buttons/actions for the toolbar              -->
          </div>
          <div class="material-datatables">
            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
          	  <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th class="no-sort">Alamat</th>
                  <th class="no-sort">Telepon</th>
                  <th class="no-sort">HP</th>
                  <th class="no-sort">Fax</th>
                  <th class="no-sort">Total Pembelian</th>
                  <th class="no-sort">Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
        <!-- end content-->
      </div>
      <!--  end card  -->
    </div>
    <!-- end col-md-12 -->
  </div>
  <!-- end row -->
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
    $('#nav_customer').addClass('active');
    $('#nav_relation').addClass('active');
	});
</script>

<script>

	$(document).ready(function(){
		$('#datatables').DataTable({
			"processing": true,
			"serverSide": true,
      "scrollX":true,
			"ajax":
				{
					"url": "{{ route('customer_load') }}",
					"dataType": "json",
					"type": "POST",
					"data":{ _token: "{{csrf_token()}}"}
				},
      "columnDefs": [ {
        "targets": 'no-sort',
        "orderable": false,
      }],
			"columns": [
			    { "data": "id" },
			    { "data": "nama" },
			    { "data": "alamat" },
			    { "data": "telepon" },
			    { "data": "hp" },
			    { "data": "fax" },
          { "data": "total_pembelian" },
			    { "data": "options" }
			]	 
		});

	  var table = $('#datatables').DataTable();

	  // Delete a record
	  table.on('click', '.remove', function(e) {
	    $tr = $(this).closest('tr');
	    table.row($tr).remove().draw();
	    e.preventDefault();
	  });
    });
</script>
@endsection