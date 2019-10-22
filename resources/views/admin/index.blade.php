@extends('layouts.app')

@section('content-header')
	Dashboard
@endsection

@section('content')
	
<!-- Body Copy -->
<div class="card">
  <div class="card-header">
    <h4>Selamat Datang, {{Auth::user()->name}}!</h4>
  </div>
  <div class="card-body">
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
  </div>
  <div class="card-footer bg-whitesmoke">
    This is card footer
  </div>
</div>       
@endsection