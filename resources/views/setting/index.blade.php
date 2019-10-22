@extends('layouts.app')

@section('content-header')
  Pengaturan
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">

 <form class="form form-horizontal" data-toggle="validator" method="post" enctype="multipart/form-data">
   {{ csrf_field() }} {{ method_field('PATCH') }}
   <div class="box-body">

  <div class="alert alert-info alert-dismissible" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i>
    Perubahan berhasil disimpan.
  </div>
  
  <div class="form-group">
    <label for="company_name" class="col-md-2 control-label">Nama Perusahaan</label>
    <div class="col-md-6">
      <input id="company_name" type="text" class="form-control" name="company_name" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="company_address" class="col-md-2 control-label">Alamat</label>
    <div class="col-md-10">
      <input id="company_address" type="text" class="form-control" name="company_address" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="company_phone_number" class="col-md-2 control-label">Telepon</label>
    <div class="col-md-4">
      <input id="company_phone_number" type="text" class="form-control" name="company_phone_number" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="company_logo" class="col-md-2 control-label">Logo Perusahaan</label>
    <div class="col-md-4">
      <input id="company_logo" type="file" class="form-control" name="company_logo">
      <br><div class="show-logo"></div>
    </div>
  </div>

  <div class="form-group">
    <label for="member_card" class="col-md-2 control-label">Desain Kartu Member</label>
    <div class="col-md-4">
      <input id="member_card" type="file" class="form-control" name="member_card">
      <br><div class="show-card"></div>
    </div>
  </div>

  <div class="form-group">
    <label for="member_discount" class="col-md-2 control-label">Diskon Member (%)</label>
    <div class="col-md-2">
      <input id="member_discount" type="number" class="form-control" name="member_discount"  required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="note_type" class="col-md-2 control-label">Tipe Nota</label>
    <div class="col-md-2">
      <select id="note_type" class="form-control" name="note_type">
        <option value="0">Nota Kecil</option>
        <option value="1">Nota Besar (PDF)</option>
      </select>
    </div>
  </div>

  </div>
  <div class="box-footer">
    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Simpan Perubahan</button>
  </div>
</form>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
$(function(){
    showData();
   $('.form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){ 

         $.ajax({
           url : "setting/1",
           type : "POST",
           data : new FormData($(".form")[0]),
           async: false,
           processData: false,
           contentType: false,
           success : function(data){
             showData();
             $('.alert').css('display', 'block').delay(2000).fadeOut();
           },
           error : function(){
             alert("Tidak dapat menyimpan data!");
           }   
         });
         return false;
     }
   });

});

function showData(){
  $.ajax({
    url : "setting/1/edit",
    type : "GET",
    dataType : "JSON",
    success : function(data){
      $('#company_name').val(data.company_name);
      $('#company_address').val(data.company_address);
      $('#company_phone_number').val(data.company_phone_number);
      $('#member_discount').val(data.member_discount);
      $('#note_type').val(data.note_type);

      d = new Date();
      $('.show-logo').html('<img src="public/images/'+data.logo+'?'+d.getTime()+'" width="200">');
      $('.show-card').html('<img src="public/images/'+data.member_card+'?'+d.getTime()+'" width="300">');
    },
    error : function(){
      alert("Tidak dapat menyimpan data!");
    }   
  });
}
</script>
@endsection