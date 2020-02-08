@extends('layouts.app')

@section('content-header')
Transaksi Pembelian
@endsection

@section('content')
<!-- Body Copy -->
<div class="card">
  <div class="card-body">
    <div class="table-responsive">       
      <table class="table table-bordered table-striped">
        <tr>
            <th width="150">Supplier</th>
            <th><b>: {{$supplier->supplier_name}}</b></th>
        </tr>
        <tr>
            <th>Alamat</th>
            <th><b>: {{$supplier->supplier_address}}</b></th>
        </tr>
        <tr>
            <th>No. Telepon</th>
            <th><b>: {{$supplier->supplier_phone_number}}</b></th>
        </tr>
      </table>
  </div>
        <form class="form form-horizontal form-product" method="POST">
            {{csrf_field()}}
            <input type="hidden" name="purchase_id" value="{{$purchase_id}}">
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
            {{csrf_field()}} {{method_field('PATCH')}}
            <div class="table-responsive"> 
            <table class="table table-stripped table-purchase">
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
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
            <div id="show-pay" style="background: #d71149; color:#ffffff; font-size:80px;
            text-align: center; height: 100px"></div>
            <div id="show-spelling" style="background: #ffffff; color: #d71149; font-weight:bold; border:5px solid #d71149; padding: 10px"></div>
        </div>
        <div class="col-md-4">
            <form class="form form-horizontal form-purchase" method="POST" action="{{route('purchase.store')}}">
                {{csrf_field()}}
                <input type="hidden" name="purchase_id" value="{{$purchase_id}}">
                <input type="hidden" name="total" id="total">
                <input type="hidden" name="total_item" id="total_item">
                <input type="hidden" name="pay" id="pay">
                <div class="form-group form-float">
                    <div class="form-line">
                        <div class="section-title">Total</div>
                        <input type="text" class="form-control" id="total_rp" readonly>
                    </div>
                </div>
                <div class="form-group form-float">
                    <div class="form-line">
                        <div class="section-title">Diskon</div>
                        <input type="number" class="form-control" id="discount" name="discount" value="0">
                    </div>
                </div>
                <div class="form-group form-float">
                    <div class="form-line">
                        <div class="section-title">Bayar</div>
                        <input type="text" class="form-control" id="pay_rp" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary save">SIMPAN TRANSAKSI</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>      
@endsection

@section('script')
@include('purchase_details.product')
<script type="text/javascript">
	var table;
	$(function(){
        $('.table-product').DataTable();
        table = $('.table-purchase').DataTable({
         "dom" : 'Brt',
         "bSort" : false,
         "processing" : true,
         "ajax" : {
            "url"  : "{{route('purchase_details.data', $purchase_id)}}",
            "type" : "GET"
        }
    }).on('draw.dt', function(){
        loadForm($('#discount').val());
    });

    $('.form-product').on('submit', function(){
        return false;
    });
    $('#product_code').change(function(){
        addItem();
    });
    $('.form-shopping-cart').submit(function(){
        return false;
    });
    $('#discount').change(function(){
        if($(this).val()=="")$(this).val(0).select();
        loadForm($(this).val());
    });
    $('.save').click(function(){
        $('.form-purchase').submit();
    });
});
	function addItem(){
        $.ajax({
            url : "{{route('purchase_details.store')}}",
            type : "POST",
            data : $('.form-product').serialize(),
            success : function(data){
                $('#product_code').val('').focus();
                table.ajax.reload(function(){
                    loadForm($('#discount').val());
                });
            },
            error : function(){
                alert("Tidak dapat menyimpan data");
            }
        })
    }
    function selectItem(product_code){
      $('#product_code').val(product_code);
      $('#modal-product').modal('hide');
      addItem();
  }

  function changeCount(id){
   $.ajax({
    url : "purchase_details/"+id,
    type : "POST",
    data : $('.form-shopping-cart').serialize(),
    success : function(data){
        $('#product_code').focus();
        table.ajax.reload(function(){
            loadForm($('#discount').val());
        });
    },
    error : function(){
        alert("Tidak dapat menyimpan data");
    }
});
}

function showProduct(){
    $('#modal-product').modal('show');
}

function deleteItem(id){
    if(confirm("Apakah yakin data akan dihapus?")){
        $.ajax({
            url     : "purchase_details/"+id,
            type    : "POST",
            data    : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
            success : function(data){
                table.ajax.reload(function(){
                    loadForm($('#discount').val());
                });
            },
            error   : function(){
                alert("Tidak dapat menghapus data");
            } 
        });
    }
}

function loadForm(discount=0){
    $('#total').val($('.total').text());
    $('#total_item').val($('.total_item').text());
    $.ajax({
        url         : "purchase_details/loadform/"+discount+"/"+$('.total').text(),
        type        : "GET",
        dataType    : "JSON",
        success     : function(data){
            $('#total_rp').val("Rp. "+data.total_rp);
            $('#pay_rp').val("Rp. "+data.pay_rp);
            $('#pay').val(data.pay);
            $('#show-pay').text("Rp. "+data.pay_rp);
            $('#show-spelling').text(data.spelling)
        },
        error       : function(){
            alert("Tidak dapat menampilkan data!");
        }
    });
}
</script>

@endsection