<div class="modal" id="modal-form" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form_validation" method="POST" data-toggle="validator">
					{{csrf_field()}} {{method_field('POST')}}
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel"></h4>
            </div>
				
                <div class="modal-body">
                <input type="hidden" id="id" name="id">
                    <div class="form-group form-float">
                        <label class="form-label">Kode Produk</label>
                        <div class="form-line">
                            <input type="number" class="form-control" id="product_code" name="product_code" autofocus required>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" autofocus required>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <select id="category" type="text" name="category" class="form-control show-tick" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($category as $list)
                                <option value="{{$list->category_id}}">{{$list->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label class="form-label">Merek Produk</label>
                            <input type="text" class="form-control" id="product_brand" name="product_brand" autofocus required>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label class="form-label">Harga Beli</label>
                            <input type="text" class="form-control" id="purchase_price" name="purchase_price" autofocus required>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label class="form-label">Diskon</label>
                            <input type="text" class="form-control" id="discount" name="discount" autofocus required>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label class="form-label">Harga Jual</label>
                            <input type="text" class="form-control" id="selling_price" name="selling_price" autofocus required>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label class="form-label">Stok Produk</label>
                            <input type="text" class="form-control" id="product_stock" name="product_stock" autofocus required>
                        </div>
                    </div>
	            </div>
	            <div class="modal-footer">
	                <button type="submit" class="btn btn-link waves-effect">SIMPAN</button>
	                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
	            </div>
            </form>
        </div>
    </div>
</div>
