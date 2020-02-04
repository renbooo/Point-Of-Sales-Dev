@extends('layouts.app')

@section('content-header')
    Penjualan
@endsection

@section('content')
<!-- Body Copy -->
<div class="card">
  <div class="card-body">
    <div class="table-responsive">
        <table class="table table-stripped table-selling">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kode Member</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Diskon</th>
                    <th>Total Bayar</th>
                    <th>Kasir</th>
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
@include('selling.detail')
<script type="text/javascript">
	var table, save_method, table1;
	$(function(){
		table = $('.table-selling').DataTable({
            "processing" : true,
            "serverside" : true,
			"ajax" : {
				"url"  : "{{route('selling.data')}}",
				"type" : "GET"
			}
        });

        table1 = $('.table-detail').DataTable({
            "dom" : 'Brt',
            "bSort" : false,
            "processing" : true
        });

        $('.table-supplier').DataTable();
    });

	function addForm(){
        $('#modal-supplier').modal('show');
	}

	function showDetail(id){
		$('#modal-detail').modal('show');
        table1.ajax.url("selling/"+id+"/show");
        table1.ajax.reload();
	}


    function deleteData(id){
        if(confirm("Apakah yakin data akan dihapus?")){
            $.ajax({
                url     : "selling/"+id,
                type    : "POST",
                data    : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
                success : function(data){
                    table.ajax.reload();
                },
                error   : function(){
                    alert("Tidak dapat menghapus data");
                } 
            });
        }
    }

</script>

@endsection