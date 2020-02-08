@extends('layouts.app')

@section('content-header')
    Pembelian
@endsection

@section('content')
<!-- Body Copy -->
<div class="card">
  <div class="card-body">
    <div class="dropdown d-inline">
      <button class="btn btn-primary" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-th-large"></i></button>
      <div class="dropdown-menu">
        <a class="dropdown-item has-icon" onclick="addForm()"><i class="fas fa-plus"></i>Transaksi Baru</a>
        @if(!empty(session('purchase_id')))
        <a class="dropdown-item has-icon" href="{{route('purchase_details.index')}}"><i class="fas fa-dollar-sign"></i>Transaksi Aktif</a>
        @endif
      </div>
  </div>
</div>
  <div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped table-purchase">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Diskon</th>
                    <th>Total Bayar</th>
                    <th>Kelola Data</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
  </div>
</div>       
@endsection

@section('script')
@include('purchase.detail')
@include('purchase.supplier')
<script type="text/javascript">
	var table, save_method, table1;
	$(function(){
		table = $('.table-purchase').DataTable({
			"language": {
            	"url" : "{{asset('tables_indo.json')}}",
         	},
			"processing" : true,
			"serverside" : true,
			"ajax" : {
				"url"  : "{{route('purchase.data')}}",
				"type" : "GET"
			}
		});

		table1 = $('.table-detail').DataTable({
			"dom"	: 'Brt',
			"bSort"	: false,
			"processing" :true
		});
		$('.table-supplier').DataTable();
	});
	function addForm(){
		$('#modal-supplier').modal('show');

	}
	function showDetail(id){
		$('#modal-detail').modal('show');

		table1.ajax.url("purchase/"+id+"/show");
		table1.ajax.reload();
	}

	function deleteData(id){
		if(confirm("Apakah yakin data akan dihapus?")){
			$.ajax({
				url		: "purchase/"+id,
				type 	: "POST",
				data 	: {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
				success : function(data){
					table.ajax.reload();
				},
				error	: function(){
					alert("Tidak dapat menghapus data");
				} 
			});
		}
	}
</script>

@endsection