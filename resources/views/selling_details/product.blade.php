<div class="modal" id="modal-product" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
	  
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
      <h3 class="modal-title">Cari Produk</h3>
   </div>
				
<div class="modal-body">
	<table class="table table-striped table-product">
		<thead>
		   <tr>
		      <th>Kode Produk</th>
		      <th>Nama Produk</th>
		      <th>Harga Beli</th>
		      <th>Aksi</th>
		   </tr>
		</thead>
		<tbody>
			@foreach($product as $data)
			<tr>
		      <th>{{ $data->product_code }}</th>
		      <th>{{ $data->product_name }}</th>
		      <th>Rp. {{ currency_format($data->purchase_price) }}</th>
		      <th><a onclick="selectItem({{ $data->product_code }})" class="btn btn-primary"><i class="fa fa-check-circle"></i> Pilih</a></th>
		    </tr>
			@endforeach
		</tbody>
	</table>

</div>
		
         </div>
      </div>
   </div>
