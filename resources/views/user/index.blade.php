@extends('layouts.app')

@section('content-header')
	Pengguna
@endsection

@section('content')
<!-- Body Copy -->
<div class="card">
  <div class="card-body">
  	<a class="btn btn-primary text-white" onclick="addForm()">Tambah Pengguna</a>
</div>
  <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama User</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
  </div>
</div>       
@endsection

@section('script')
@include('user.form')
<script type="text/javascript">
	var table, save_method;
	$(function(){
		table = $('.table').DataTable({
			"processing" : true,
			"ajax" : {
				"url"  : "{{route('user.data')}}",
				"type" : "GET"
			}
		});
		$('#modal-form form').validator().on('submit', function(e){
			if(!e.isDefaultPrevented()){
				var id = $('#id').val();
				if(save_method == "add") url = "{{route('user.store')}}";
				else url = "user/"+id;

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
		$('.modal-title').text('Tambah User');
		$('#password, #loop_password').attr('required', true);
	}
	function editForm(id){
		save_method = "edit";
		$('input[name=_method]').val('PATCH');
		$('#modal-form form')[0].reset();
		$.ajax({
			url			: "user/"+id+"/edit",
			type 		: "GET",
			dataType	: "JSON",
			success		: function(data){
				$('#modal-form').modal('show');
				$('.modal-title').text('Edit User');

				$('#id').val(data.id);
				$('#name').val(data.name);
				$('#email').val(data.email);
				$('#password, #loop_password').removeAttr('required');
			},
			error		: function(){
				alert("Tidak dapat menampilkan data!");
			}
		});
	}

	function deleteData(id){
		if(confirm("Apakah yakin data akan dihapus?")){
			$.ajax({
				url		: "user/"+id,
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