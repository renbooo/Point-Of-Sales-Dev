<!DOCTYPE html>
<html>
<head>
	<title>Cetak Barcode</title>
</head>
<body>
	<table width="100%">
		<tr>
			@foreach($data_product as $data)
			<td align="center" style="border: 1px solid #ccc">
				<span>{{$data->product_name}} - Rp. {{currency_format($data->purchase_price)}}</span><br>
				<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($data->product_code, 'C39')}}" height="60" width="180">
			</td>
			@if($no++ % 3 == 0)
		</tr>
		<tr>
			@endif
			@endforeach
		</tr>
	</table>
</body>
</html>