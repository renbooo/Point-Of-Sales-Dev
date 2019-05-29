<!DOCTYPE html>
<html>
<head>
	<title>Cetak Kartu Member</title>
	<style type="text/css">
		.box{position: relative;}
		.card{width: 501.732pt; height: 147.402pt;}
		.code{
			position: absolute;
			top: 105pt;
			left: 10pt;
			color:#000;
			font-size: 15pt;
		}
		.barcode{
			position: absolute;
			top: 23pt;
			right: 5pt;
			font-size: 10pt;
		}
	</style>
</head>

<body>
	<table width="100%">
		@foreach($data_member as $data)
		<tr>
			<td align="center">
				<div class="box">
					<img src="{{public_path('images/member-card.png')}}" class="card">
					<div class="code">{{$data->member_code}}</div>
					<div class="barcode">
						<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($data->member_code, 'C39')}}" height="30" width="100">
						<br>
						{{$data->member_code}}
					</div>
				</div>
			</td>
		</tr>
		@endforeach
	</table>
</body>
</html>