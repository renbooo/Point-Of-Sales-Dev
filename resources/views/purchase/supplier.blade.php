<div class="modal fade" id="modal-supplier" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel"></h4>
            </div>
				
                <div class="modal-body">
                    <div class="body table-responsive">
                            <table class="table table-striped table-supplier">
                                <thead>
                                    <tr>
                                        <th>Nama Supplier</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($supplier as $data)
                                    <tr>
                                        <td>{{$data->supplier_name}}</td>
                                        <td>{{$data->supplier_address}}</td>
                                        <td>{{$data->supplier_phone_number}}</td>
                                        <td><a href="purchase/{{$data->supplier_id}}/add">Pilih</a></td>
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
