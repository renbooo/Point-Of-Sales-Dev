@extends('layouts.app')

@section('content-header')
	Profil
@endsection

@section('content')     
<div class="card">
  <div class="card-body">

 <form class="form form-horizontal" data-toggle="validator" method="post" enctype="multipart/form-data">
   {{ csrf_field() }} {{ method_field('PATCH') }}
   <div class="box-body">

  <div class="alert alert-info alert-dismissible" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i>
    Perubahan berhasil disimpan.
  </div>

 <div class="form-group row align-items-center">
    <label class="form-control-label col-sm-3">Foto Profil</label>
    <div class="col-sm-6 col-md-9">
      <div class="show-photo">
          <img src="{{ asset('images/'.Auth::user()->photos) }}" width="200">
      </div>
      <div class="custom-file">
        <input type="file" name="photos" class="custom-file-input" id="photos">
        <label for="photos" class="custom-file-label">Choose File</label>
        <span class="help-block with-errors"></span>
      </div>
    </div>
  </div>
    
  <div class="form-group row align-items-center">
    <label for="old_password" class="form-control-label col-sm-3">Password Lama</label>
    <div class="col-sm-6 col-md-9">
      <input type="password" name="old_password" class="form-control" id="old_password">
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group row align-items-center">
    <label for="password" class="form-control-label col-sm-3">Password Baru</label>
    <div class="col-sm-6 col-md-9">
      <input type="password" name="password" class="form-control" id="password">
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group row align-items-center">
      <label for="loop_password" class="form-control-label col-sm-3">Ulangi Password Baru</label>
      <div class="col-sm-6 col-md-9">
         <input type="password" class="form-control" data-match="#password" name="loop_password" id="loop_password">
         <span class="help-block with-errors"></span>
      </div>
  </div>

  </div>
  <div class="card-footer bg-whitesmoke text-md-right">
    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Simpan Perubahan</button>
  </div>
</form>
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