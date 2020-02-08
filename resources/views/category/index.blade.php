@extends('layouts.app')

@section('content-header')
	Kategori
@endsection

@section('content')
<!-- Body Copy -->
<div class="card">
  <div class="card-body">
  	<div class="dropdown d-inline">
      <button class="btn btn-primary" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-th-large"></i></button>
      <div class="dropdown-menu">
      	<a class="dropdown-item has-icon" onclick="addForm()"><i class="fas fa-plus"></i>Tambah Kategori</a>
      </div>
</div>
  <div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped">
        	<thead>
         <tr>
                <th>No</th>
                <th>Nama Kategori</th>
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
@include('category.form')

<script type="text/javascript">
	var table, save_method;
	$(function(){
		table = $('.table').DataTable({
			"language": {
				"url" : "{{asset('tables_indo.json')}}",
			},
			"processing" : true,
			"ajax" : {
				"url"  : "{{route('category.data')}}",
				"type" : "GET"
			}
		});
		$('#modal-form form').validator().on('submit', function(e){
			if(!e.isDefaultPrevented()){
				var id = $('#id').val();
				if(save_method == "add") url = "{{route('category.store')}}";
				else url = "category/"+id;

				$.ajax({
					url  	: url,
					type 	: "POST",
					data 	: $('#modal-form form').serialize(),
					success : function(data){
						$('#modal-form').modal('hide');
						table.ajax.reload();
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
		$('.modal-title').text('Tambah Kategori');
	}
	function editForm(id){
		save_method = "edit";
		$('input[name=_method]').val('PATCH');
		$('#modal-form form')[0].reset();
		$.ajax({
			url			: "category/"+id+"/edit",
			type 		: "GET",
			dataType	: "JSON",
			success		: function(data){
				$('#modal-form').modal('show');
				$('.modal-title').text('Edit Kategori');

				$('#id').val(data.category_id);
				$('#category_name').val(data.category_name);
			},
			error		: function(){
				alert("Tidak dapat menampilkan data!");
			}
		});
	}

	function deleteData(id){
		if(confirm("Apakah yakin data akan dihapus?")){
			$.ajax({
				url		: "category/"+id,
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