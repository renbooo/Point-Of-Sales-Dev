<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form_validation" method="POST" data-toggle="validator" role="form">
					{{csrf_field()}} {{method_field('POST')}}
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel"></h4>
            </div>
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group form-float">
                        <div class="form-line">
                        	
                        	<label class="form-label">Nama User</label>
                            <input type="text" class="form-control" id="name" name="name" autofocus required>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" autofocus required>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">                            
                            <label class="form-label">Ulangi Password</label>
                            <input type="password" class="form-control" id="loop_password" data-match="#password" data-match-error="Maaf password tidak sama" name="loop_password" required>
                        </div>
                        <span class="help-block with-errors"></span>
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
