<!DOCTYPE html>
<html>
<head>  
  <title>Produk PDF</title>
  <link rel="stylesheet" href="{{ asset('stisla/css/bootstrap.min.css') }}">
</head>
<body>
 
<h3 class="text-center">Laporan Pendapatan</h3>
<h4 class="text-center">Tanggal  {{ indo_date($date_begin) }} s/d {{ indo_date($date_end) }} </h4>

         
<table class="table table-striped">
<thead>
   <tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Penjualan</th>
    <th>Pembelian</th>
    <th>Pengeluaran</th>
    <th>Pendapatan</th>
   </tr>
</thead>
   <tbody>
    @foreach($data as $row)    
    <tr>
    @foreach($row as $col)
     <td>{{ $col }}</td>
    @endforeach
    </tr>
    @endforeach
   </tbody>
</table>

</body>
</html>