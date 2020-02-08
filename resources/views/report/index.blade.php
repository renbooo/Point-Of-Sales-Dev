@extends('layouts.app')

@section('content-header')
    Laporan Pendapatan {{ indo_date($begin, false) }} - {{ indo_date($end, false) }}
@endsection

@section('content')
<!-- Body Copy -->
<div class="card">
  <div class="card-body">
    <div class="dropdown d-inline">
      <button class="btn btn-primary" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-th-large"></i></button>
      <div class="dropdown-menu">
      <a class="dropdown-item has-icon" onclick="periodForm()"><i class="fas fa-calendar-alt"></i>Ubah Periode</a>
      <a href="report/pdf/{{$begin}}/{{$end}}" target="_blank" class="dropdown-item has-icon"><i class="fas fa-file-pdf"></i>Export PDF</a>
      </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">       
      <form method="POST" id="form-product">
        {{csrf_field()}}
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
            <tbody>
              <tr>
              </tr>
            </tbody>
          </table>
        
      </form>
    </div>
  </div>
</div>       
@endsection

@section('script')
@include('report.form')
<script type="text/javascript">
var table, begin, end;
$(function(){
   table = $('.table-report').DataTable({
     "language": {
        "url" : "{{asset('tables_indo.json')}}",
     },
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