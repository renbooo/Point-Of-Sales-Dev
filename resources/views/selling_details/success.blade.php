@extends('layouts.app')

@section('title')
  Selesai Transaksi
@endsection

@section('breadcrumb')
   @parent  
   <li>Transaksi</li>
   <li>Selesai</li>
@endsection

@section('content') 
<div class="row">
  <div class="col-xs-12">
    <div class="box">
       <div class="box-body">
          <div class="alert alert-success alert-dismissible">
            <i class="icon fa fa-check"></i>
            Data Transaksi telah disimpan.
          </div>

          <br><br>
          @if($setting->nota_type==0)
            <a class="btn btn-warning btn-lg" href="{{ route('transaction.print') }}">Cetak Ulang Nota</a>
          @else
            <a class="btn btn-warning btn-lg" onclick="showNote()">Cetak Ulang Nota</a>
            <script type="text/javascript">
              showNota();
              function showNote(){
                window.open("{{ route('transaction.pdf') }}", "Nota PDF", "height=650,width=1024,left=150,scrollbars=yes");
              }              
            </script>
          @endif
          <a class="btn btn-primary btn-lg" href="{{ route('transaction.new') }}">Transaksi Baru</a>
          <br><br><br><br>
      </div>
   </div>
  </div>
</div>
@endsection