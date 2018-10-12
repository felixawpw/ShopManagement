@extends('layouts.master')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <div class="row">
            <div class="col-md-auto">
              <h4 class="card-title ">Data Pembelian</h4>
              <p class="card-category"></p>
            </div>
            <div class="col-md-auto ml-auto">
              <a href="{{route('pembelian.create')}}">
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
                  <th>Nomor Nota</th>
                  <th>Tanggal Transaksi</th>
                  <th>Jatuh Tempo</th>
                  <th>Total</th>
                  <th>Nomor Faktur</th>
                  <th>Nama Supplier</th>
                  <th>Nama User</th>
                  <th>Status Pembayaran</th>
                  <th class="disabled-sorting text-right">Actions</th>
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
		$('#nav_pembelian').addClass('active');
    $('#nav_transaksi').addClass('active');	});
</script>

<script>

	$(document).ready(function(){
		$('#datatables').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax":
				{
					"url": "{{ route('pembelian_load') }}",
					"dataType": "json",
					"type": "POST",
					"data":{ _token: "{{csrf_token()}}"}
				},
      columnDefs: [ { orderable: false, targets: [6,7,9] } ],
			"columns": [
			    { "data": "id" },
			    { "data": "no_nota" },
			    { "data": "tanggal" },
			    { "data": "tanggal_due" },
			    { "data": "total" },
			    { "data": "no_faktur" },
          { "data": "nama_supplier" },
          { "data": "nama_user" },
          { "data": "status_pembayaran" },
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