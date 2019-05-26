<div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form_validation" method="POST" data-toggle="validator">
					{{csrf_field()}} {{method_field('POST')}}
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel"></h4>
            </div>
				
                <div class="modal-body">
                    <div class="form-group form-float">
                        <div class="form-line">
                        	<input type="hidden" id="id" name="id">
                        	<label class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" autofocus required>
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
