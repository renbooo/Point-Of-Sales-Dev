@extends('layouts.app')

@section('content-header')
    Laporan Pendapatan {{ indo_date($begin, false) }} sampai {{ indo_date($end, false) }}
@endsection

@section('breadcrumb')
   @parent
   <li>laporan</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <a onclick="periodForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> Ubah Periode</a>
        <a href="report/pdf/{{$begin}}/{{$end}}" target="_blank" class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
      </div>
      <div class="box-body">  

<table class="table table-striped table-report">
<thead>
   <tr>
      <th width="30">No</th>
      <th>Tanggal</th>
      <th>Penjualan</th>
      <th>Pembelian</th>
      <th>Pengeluaran</th>
      <th>Pendapatan</th>
   </tr>
</thead>
<tbody></tbody>
</table>

      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
@include('report.form')
<script type="text/javascript">
var table, begin, end;
$(function(){
   $('#begin, #end').datepicker({
     format: 'yyyy-mm-dd',
     autoclose: true
   });

   table = $('.table-report').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "bPaginate" : false,
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "report/data/{{ $begin }}/{{ $end }}",
       "type" : "GET"
     }
   }); 

});

function periodForm(){
   $('#modal-form').modal('show');        
}

</script>
@endsection