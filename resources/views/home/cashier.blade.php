@extends('layouts.app')

@section('title')
	Dashboard
@endsection

@section('content')
	
<div class="row">
  <div class="col-xs-12">
    <div class="box">
       <div class="box-body text-center">
            <h1>Selamat Datang</h1>
            <h2>Anda login sebagai KASIR</h2>
            <br><br>
            <a class="btn btn-success btn-lg" href="{{ route('transaction.new') }}">Transaksi Baru</a>
            <br><br><br>
      </div>
   </div>
  </div>
</div>
@endsection