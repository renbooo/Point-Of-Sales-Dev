@extends('layouts.app')

@section('title')
	Daftar Produk
@endsection

@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Daftar Produk
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a onclick="addForm()">Tambah Kategori</a></li>
                                <li><a onclick="printBarcode()">Cetak Barcode</a></li>
                                <li><a onclick="deleteAll()">Hapus yang tercentang</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                    	<form method="POST" id="form-product">
                    		{{csrf_field()}}
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                	<th width="20"><input type="checkbox" value="1" id="select-all"></th>
                                    <th width="20">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Merek</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Diskon</th>
                                    <th>Stok</th>
                                    <th width="100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    	</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('product.form')

@section('script')
<script type="text/javascript">
	var table, save_method;
	$(function(){
		table = $('.table').DataTable({
			"processing" : true,
			"serverside" : true,
			"ajax" : {
				"url"  : "{{route('product.data')}}",
				"type" : "GET"
			},
			"columnDefs" : [{
				'targets' : 0,
				'searchable': false,
				'orderable' : false
			}],
			"order":[1, 'asc']
		});

		$('#select-all').click(function(){
			$('input[type="checkbox"]').prop('checked', this.checked);
		});

		$('#modal-form form').validator().on('submit', function(e){
			if(!e.isDefaultPrevented()){
				var id = $('#id').val();
				if(save_method == "add") url = "{{route('product.store')}}";
				else url = "product/"+id;

				$.ajax({
					url  	: url,
					type 	: "POST",
					data 	: $('#modal-form form').serialize(),
					dataType : "JSON",
					success : function(data){
						if(data.msg=="error"){
							alert('Kode produk sudah terpakai');
							$('#product_code').focus().select();
						}else{
							$('#modal-form').modal('hide');
							table.ajax.reload();
						}
					},
					error : function(){
						alert("Tidak dapat menyimpan data");
					}
				});
				return false;
			}
		});
	});
	function addForm(){
		save_method = "add";
		$('input[name=_method]').val('POST');
		$('#modal-form').modal('show');
		$('#modal-form form')[0].reset();
		$('.modal-title').text('Tambah Produk');
		$('#product_code').attr('readonly', false);
	}
	function editForm(id){
		save_method = "edit";
		$('input[name=_method]').val('PATCH');
		$('#modal-form form')[0].reset();
		$.ajax({
			url			: "product/"+id+"/edit",
			type 		: "GET",
			dataType	: "JSON",
			success		: function(data){
				$('#modal-form').modal('show');
				$('.modal-title').text('Edit Produk');

				$('#id').val(data.product_id);
				$('#product_code').val(data.product_code).attr('readonly', true);
				$('#product_name').val(data.product_name);
				$('#category').val(data.category_id);
				$('#product_brand').val(data.product_brand);
				$('#purchase_price').val(data.purchase_price);
				$('#discount').val(data.discount);
				$('#selling_price').val(data.selling_price);
				$('#product_stock').val(data.product_stock);
			},
			error		: function(){
				alert("Tidak dapat menampilkan data!");
			}
		});
	}

	function deleteData(id){
		if(confirm("Apakah yakin data akan dihapus?")){
			$.ajax({
				url		: "product/"+id,
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

	function deleteAll(){
		if ($('input:checked').length < 1) {
			alert('Pilih data yang akan dihapus!');
		}else{
			$('#form-product').attr('target', '_blank').attr('action', "product/print").submit();
		}
	}
</script>

@endsection