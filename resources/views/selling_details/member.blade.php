<div class="modal" id="modal-member" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
     
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
      <h3 class="modal-title">Cari Member</h3>
   </div>
            
<div class="modal-body">
   <table class="table table-striped tabel-produk">
      <thead>
         <tr>
            <th>Kode Member</th>
            <th>Nama Member</th>
            <th>Alamat</th>
            <th>Telpon</th>
            <th>Aksi</th>
         </tr>
      </thead>
      <tbody>
         @foreach($member as $data)
         <tr>
            <th>{{ $data->member_code }}</th>
            <th>{{ $data->member_name }}</th>
            <th>{{ $data->member_address }}</th>
            <th>{{ $data->member_phone_number }}</th>
            <th><a onclick="selectMember({{ $data->member_code }})" class="btn btn-primary"><i class="fa fa-check-circle"></i> Pilih</a></th>
          </tr>
         @endforeach
      </tbody>
   </table>

</div>
      
         </div>
      </div>
   </div>
