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
                        	<label class="form-label">Nama Member</label>
                            <input type="text" class="form-control" id="member_name" name="member_name" autofocus required>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">                        	
                        	<label class="form-label">Kode Member</label>
                            <input type="text" class="form-control" id="member_code" name="member_code" autofocus required>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">                         
                            <label class="form-label">Alamat Member</label>
                            <input type="text" class="form-control" id="member_address" name="member_address" autofocus required>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">                         
                            <label class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="member_phone_number" name="member_phone_number" autofocus required>
                        </div>
                    </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn btn-primary">SIMPAN</button>
	            </div>
            </form>
        </div>
    </div>
</div>
