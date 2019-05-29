<div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
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
                        <div class="form-line">                        	
                        	<label class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control" id="supplier_name" name="supplier_name" autofocus required>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">                         
                            <label class="form-label">Alamat Supplier</label>
                            <input type="text" class="form-control" id="supplier_address" name="supplier_address" autofocus required>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">                         
                            <label class="form-label">No. Telp</label>
                            <input type="text" class="form-control" id="supplier_phone_number" name="supplier_phone_number" autofocus required>
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
