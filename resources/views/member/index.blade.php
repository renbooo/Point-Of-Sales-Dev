@extends('layouts.app')

@section('content-header')
	Member
@endsection

@section('content')
<!-- Body Copy -->
<div class="card">
  <div class="card-body">
  	<div class="dropdown d-inline">
      <button class="btn btn-primary" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-th-large"></i>
      </button>
      <div class="dropdown-menu">
      	<a class="dropdown-item has-icon" onclick="addForm()"><i class="fas fa-plus"></i>Tambah Member</a>
	  	<a class="dropdown-item has-icon" onclick="printCard()"><i class="fas fa-print"></i>Print Kartu Member</a>
      </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
    	<form method="POST" id="form-member">
    		{{csrf_field()}}
        <table class="table table-striped table-hover js-basic-example dataTable">
            <thead>
                <tr>
                	<th width="20">
                		<input type="checkbox" class="filled-in" value="1" id="ig_checkbox">
                      	<label for="ig_checkbox"></label>
                  	</th>
                    <th>No</th>
                    <th>Kode Member</th>
                    <th>Nama Member</th>
                    <th>Alamat</th>
                    <th>Nomor Telepon</th>
                    <th>Kelola Data</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </form>
    </div>
  </div>
</div>       
@endsection

@section('script')
@include('member.form')
<script type="text/javascript">
	var table, save_method;
	$(function(){
		table = $('.table').DataTable({
			"language": {
            	"url" : "{{asset('tables_indo.json')}}",
         	},
			"processing" : true,
			"serverside" : true,
			"ajax" : {
				"url"  : "{{route('member.data')}}",
				"type" : "GET"
			},
			"columnDefs" : [{
				'targets' : 0,
				'searchable': false,
				'orderable' : false
			}],
			"order":[1, 'asc']
		});

		$('#ig_checkbox').click(function(){
			$('input[type="checkbox"]').prop('checked', this.checked);
		});

		$('#modal-form form').validator().on('submit', function(e){
			if(!e.isDefaultPrevented()){
				var id = $('#id').val();
				if(save_method == "add") url = "{{route('member.store')}}";
				else url = "member/"+id;

				$.ajax({
					url  	: url,
					type 	: "POST",
					data 	: $('#modal-form form').serialize(),
					dataType : "JSON",
					success : function(data){
						if(data.msg=="error"){
							alert('Kode member sudah terpakai');
							$('#member_code').focus().select();
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
		$('.modal-title').text('Tambah Member');
		$('#member_code').attr('readonly', false);
	}
	function editForm(id){
		save_method = "edit";
		$('input[name=_method]').val('PATCH');
		$('#modal-form form')[0].reset();
		$.ajax({
			url			: "member/"+id+"/edit",
			type 		: "GET",
			dataType	: "JSON",
			success		: function(data){
				$('#modal-form').modal('show');
				$('.modal-title').text('Edit Member');

				$('#id').val(data.member_id);
				$('#member_code').val(data.member_code).attr('readonly', true);
				$('#member_name').val(data.member_name);
				$('#member_address').val(data.member_address);
				$('#member_phone_number').val(data.member_phone_number);
			},
			error		: function(){
				alert("Tidak dapat menampilkan data!");
			}
		});
	}

	function deleteData(id){
		if(confirm("Apakah yakin data akan dihapus?")){
			$.ajax({
				url		: "member/"+id,
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

	function printCard(){
		if ($('input:checked').length < 1) {
			alert('Pilih data yang akan dicetak!');
		}else{
			$('#form-member').attr('target', '_blank').attr('action', "member/print/").submit();
		}
	}
</script>

@endsection