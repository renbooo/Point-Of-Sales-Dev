@extends('layouts.app')

@section('content-header')
	Dashboard
@endsection

@section('content')
	<div class="card">
		<div class="card-body text-center">
		    <h1>Selamat Datang {{Auth::user()->name}}</h1>
		    <h2>Anda login sebagai KASIR</h2>
		    <h4>Semangat bekerja, karena nikah juga butuh modal</h4>
		    <a class="btn btn-success btn-lg" href="{{ route('transaction.new') }}">BUAT TRANSAKSI</a>
		</div>
	</div>
@endsection