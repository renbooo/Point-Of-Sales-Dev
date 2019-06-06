@extends('layouts.app')

@section('title')
	Daftar Penjualan
@endsection

@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Penjualan
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a onclick="addForm()">Transaksi Baru</a></li>
                                @if(!empty(session('purchase_id')))
                                <li><a href="{{route('purchase_details.index')}}">Transaksi Aktif</a></li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <table class="table table-stripped table-purchase">
                        <thead>
                            <tr>
                                <th width="30">No</th>
                                <th>Tanggal</th>
                                <th>Kode Member</th>
                                <th>Total Item</th>
                                <th>Total Harga</th>
                                <th>Diskon</th>
                                <th>Total Bayar</th>
                                <th>Kasir</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('selling_details.detail')

@section('script')
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
        table1.ajax.url("purchase/"+id+"/show");
        table1.ajax.reload();
	}


    function deleteData(id){
        if(confirm("Apakah yakin data akan dihapus?")){
            $.ajax({
                url     : "selling/"+id,
                type    : "POST",
                data    : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
                success : function(data){
                    table.ajax.reload(function();
                },
                error   : function(){
                    alert("Tidak dapat menghapus data");
                } 
            });
        }
    }

</script>

@endsection