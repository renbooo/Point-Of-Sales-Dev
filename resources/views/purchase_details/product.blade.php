<div class="modal fade" id="modal-product" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel"></h4>
            </div>
				
                <div class="modal-body">
                    <div class="body table-responsive table-supplier">
                            <table class="table">
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
                                        <td>{{$data->product_code}}</td>
                                        <td>{{$data->product_name}}</td>
                                        <td>Rp. {{currency_format($data->purchase_price)}}</td>
                                        <td><a onclick="selectItem({{$data->product_code}})">Pilih</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
	            </div>
        </div>
    </div>
</div>
