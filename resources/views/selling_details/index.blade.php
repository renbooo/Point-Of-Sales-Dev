@extends('layouts.app')

@section('content-header')
  Detail Penjualan
@endsection

@section('content')
  <div class="card">
    <div class="card-body">     
      <form class="form form-horizontal form-product" method="post">
        {{ csrf_field() }}  
        <input type="hidden" name="selling_id" value="{{ $selling_id }}">
          <div class="section-title">Kode Produk</div>
          <div class="form-group">
            <div class="input-group mb-3">
              <input id="product_code" name="product_code" type="text" class="form-control" placeholder="" aria-label="" autofocus required>
              <div class="input-group-append">
                <button class="btn btn-primary" type="button" onclick="showProduct()">....</button>
              </div>
            </div>
          </div>
      </form>

      <form class="form-shopping-cart">
        {{ csrf_field() }} {{ method_field('PATCH') }}
        <div class="table-responsive"> 
          <table class="table table-striped table-selling">
            <thead>
              <tr>
                <th width="30">No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Diskon</th>
                <th>Sub Total</th>
                <th width="100">Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </form>
    </div>

    <div class="card-body">
      <div class="row">
        <div class="col-md-8">
          <div id="show-pay" style="background: #d71149; color:#ffffff; font-size:80px; text-align: center; height: 250px"></div>
          <div id="show-spelling" style="background: #ffffff; color: #d71149; font-size: 25px; border:5px solid #d71149; padding: 10px"></div>
        </div>

        <div class="col-md-4">
          <form class="form form-horizontal form-selling" method="post" action="transaction/save">
            {{ csrf_field() }}
            <input type="hidden" name="selling_id" value="{{ $selling_id }}">
            <input type="hidden" name="total" id="total">
            <input type="hidden" name="total_item" id="total_item">
            <input type="hidden" name="pay" id="pay">

            <div class="section-title">Total</div>
            <div class="form-group">
              <input type="text" class="form-control" id="total_rp" readonly>  
            </div>

            <div class="section-title">Kode Member</div>
            <div class="form-group">
              <div class="input-group mb-3">
                <input id="member_code" name="member_code" value="0" type="text" class="form-control" placeholder="" aria-label="" autofocus required>
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button" onclick="showMember()">....</button>
                </div>
              </div>
            </div>

            <div class="section-title">Kode Member</div>
            <div class="form-group">           
              <input type="text" class="form-control" name="discount" id="discount" value="0" readonly>
            </div>

            <div class="section-title">Bayar</div>
            <div class="form-group">            
              <input type="text" class="form-control" id="pay_rp" readonly>
            </div>

            <div class="section-title">Diterima</div>
            <div class="form-group">
              <input type="number" class="form-control" value="0" name="received" id="received">  
            </div>

            <div class="section-title">Kembali</div>
            <div class="form-group">
              <input type="text" class="form-control" id="remaining" value="0" readonly>
            </div>
          </form>
        </div>
      </div>
    </div>
          
    <div class="box-footer">
      <button type="submit" class="btn btn-primary pull-right save float-right mb-5 mr-4">
        Simpan Transaksi
      </button>
    </div>
  </div>
@endsection

@section('script')

@include('selling_details.product')
@include('selling_details.member')

  <script type="text/javascript">
    var table;
    $(function(){
      $('.table-product').DataTable();
      table = $('.table-selling').DataTable({
         "dom" : 'Brt',
         "bSort" : false,
         "processing" : true,
         "ajax" : {
           "url" : "{{ route('transaction.data', $selling_id) }}",
           "type" : "GET"
         }
      }).on('draw.dt', function(){
        loadForm($('#discount').val());
      });

      $('.form-product').on('submit', function(){
        return false;
      });

      $('body').addClass('sidebar-collapse');

      $('#product_code').change(function(){
        addItem();
      });

      $('.form-shopping-cart').submit(function(){
        return false;
      });

      $('#member_code').change(function(){
        selectMember($(this).val());
      });

      $('#received').change(function(){
        if($(this).val() == "") $(this).val(0).select();
        loadForm($('#discount').val(), $(this).val());
      }).focus(function(){
        $(this).select();
      });

      $('.save').click(function(){
        $('.form-selling').submit();
      });
    });

    function addItem(){
      $.ajax({
        url : "{{ route('transaction.store') }}",
        type : "POST",
        data : $('.form-product').serialize(),
        success : function(data){
          $('#product_code').val('').focus();
          table.ajax.reload(function(){
             loadForm($('#discount').val());
          });             
        },
        error : function(){
          alert("Tidak dapat menyimpan data!");
        }   
      });
    }

    function showProduct(){
      $('#modal-product').modal('show');
    }

    function showMember(){
      $('#modal-member').modal('show');
    }

    function selectItem(product_code){
      $('#product_code').val(product_code);
      $('#modal-product').modal('hide');
      addItem();
    }

    function changeCount(id){
         $.ajax({
            url : "transaction/"+id,
            type : "POST",
            data : $('.form-shopping-cart').serialize(),
            success : function(data){
              $('#product_code').focus();
              table.ajax.reload(function(){
                loadForm($('#discount').val());
              });             
            },
            error : function(){
              alert("Tidak dapat menyimpan data!");
            }   
         });
    }

    function selectMember(member_code){
      $('#modal-member').modal('hide');
      $('#discount').val('{{ $setting->member_discount }}');
      $('#member_code').val(member_code);
      loadForm($('#discount').val());
      $('#received').val(0).focus().select();
    }

    function deleteItem(id){
       if(confirm("Apakah yakin data akan dihapus?")){
         $.ajax({
           url : "transaction/"+id,
           type : "POST",
           data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
           success : function(data){
             table.ajax.reload(function(){
                loadForm($('#discount').val());
              }); 
           },
           error : function(){
             alert("Tidak dapat menghapus data!");
           }
         });
       }
    }

    function loadForm(discount=0, received=0){
      $('#total').val($('.total').text());
      $('#total_item').val($('.total_item').text());

      $.ajax({
           url : "transaction/loadform/"+discount+"/"+$('#total').val()+"/"+received,
           type : "GET",
           dataType : 'JSON',
           success : function(data){
             $('#total_rp').val("Rp. "+data.total_rp);
             $('#pay_rp').val("Rp. "+data.pay_rp);
             $('#pay').val(data.pay);
             $('#show-pay').html("<small>Bayar: </small><br>Rp. "+data.pay_rp);
             $('#show-spelling').text(data.spelling);
            
             $('#remaining').val("Rp. "+data.remaining_rp);
             if($('#received').val() != 0){
                $('#show-pay').html("<small>Kembali: </small><br>Rp. "+data.remaining_rp+"</small>");
                $('#show-spelling').text(data.remaining_spelling);
             }
           },
           error : function(){
             alert("Tidak dapat menampilkan data!");
           }
      });
    }
  </script>
@endsection