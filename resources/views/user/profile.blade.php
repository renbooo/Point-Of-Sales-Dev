@extends('layouts.app')

@section('title')
	Daftar User
@endsection

@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Daftar User
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a onclick="addForm()">Tambah User</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <form id="frmFileUpload" class="dropzone form" method="post" enctype="multipart/form-data">
                    	{{csrf_field()}} {{method_field('PATCH')}}
                        <div class="dz-message">
                            <div class="drag-icon-cph">
                                <i class="material-icons">touch_app</i>
                            </div>
                            <h3>Upload Foto Profil</h3>
                            <em>(Tarik file ke kotak atau klik kotak ini)</em>
                        </div>
                        <div class="fallback">
                            <input name="file" type="file" multiple />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
	var table, save_method;
	$(function(){
		$('#old_password').keyup(function(){
			if($(this).val() != "") $('#password, #loop_password').attr('required', true);
			else $('#password, #loop_password').attr('required', false);
		});
		$('.form').validator().on('submit', function(e){
			if (!e.isDefaultPrevented()) {
				$.ajax({
					url			: "{{Auth::user()->id}}/change",
					type		: "POST",
					data 		: new FormData($(".form")[0]),
					dataType 	: 'JSON',
					async 		: false,
					processData : false,
					contentType : false,
					success 	: function(data){
						if (data.msg == "error") {
							alert('Password lama salah!');
							$('#old_password').focus().select();
						}else{
							dt = new Data();
							$('.alert').css('display', 'block').delay(2000).fadeOut();
							$('.show-photo img, .user-image, .user-header img').attr('src', data.url+'?'+dt.getTime());
						}
					},
					error		: function(){
						alert("Tidak dapat menyimpan data");
					}	
				});
				return false;
			}
		});
	});
</script>

@endsection