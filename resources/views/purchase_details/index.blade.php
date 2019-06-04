@extends('layouts.app')

@section('title')
	Transaksi Pembelian
@endsection

@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Transaksi Pembelian
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a onclick="addForm()">Transaksi Baru</a></li>
                                @if(!empty(session('purchase_id')))
                                <li><a href="{{route('purchase_details.index')}}">Transaksi Aktif</a></li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tr><td width="150">Supplier</td><td><b>{{$supplier->supplier_name}}</b></td></tr>
                            <tr><td>Alamat</td><td><b>{{$supplier->supplier_address}}</b></td></tr>
                            <tr><td>No. Telepon</td><td><b>{{$supplier->supplier_phone_number}}</b></td></tr>
                        </table>
                        <hr>
                        <form class="form form-horizontal form-product" method="POST">
                            {{csrf_field()}}
                            <input type="hidden" name="purchase_id" value="{{$purchase_id}}">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">Kode Produk</label>
                                    <input type="text" class="form-control" id="product_code" name="product_code" autofocus required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="showProduct()" class="btn btn-info waves-effect">....</button>
                                </div>
                            </div>
                        </form>
                        <form class="form-bucket">
                            {{csrf_field()}} {{method_field('PATCH')}}
                            <table class="table table-stripped table-purchase">
                                <thead>
                                    <tr>
                                        <th width="30">No</th>
                                        <th>Kode Produk</th>
                                        <th>Nama Produk</th>
                                        <th align="right">Harga</th>
                                        <th>Jumlah</th>
                                        <th align="right">Sub Total</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </form>
                        <div class="col-md-8">
                            <div id="show-pay" style="background: #dd4b39; color: #fff; font-size:80px;
                            text-align: center; height: 100px"></div>
                            <div id="show-spelling" style="background: #3c8dbc; color: #fff; font-weight:bold; padding: 10px"></div>
                        </div>
                        <div class="col-md-4">
                            <form class="form form-horizontal form-purchase" method="POST" action="{{route('purchase.store')}}">
                                {{csrf_field()}}
                                <input type="hidden" name="purchase_id" value="{{purchase_id}}">
                                <input type="hidden" name="total" id="total">
                                <input type="hidden" name="totalItem" id="totalItem">
                                <input type="hidden" name="pay" id="pay">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Total</label>
                                        <input type="text" class="form-control" id="totalrp" readonly>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Diskon</label>
                                        <input type="number" class="form-control" id="discount" name="discount" value="0">
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Bayar</label>
                                        <input type="text" class="form-control" id="payrp" readonly>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-link waves-effect">SIMPAN TRANSAKSI</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('purchase_details.product')

@section('script')
<script type="text/javascript">
	var table, save_method, table1;
	$(function(){
		table = $('.table-product').DataTable({
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

        $('.form-bucket').submit(function(){
            return false;
        });
        $('#product_code').change(function(){
            addItem();
        })
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
            url : "{{route('purchase_details')}}",
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
	function selectItem(code){
		$('#product_code').val('code');
        $('#modal-product').modal('hide');
        addItem();
	}

	function changeCount(id){
	        $.ajax({
            url : "purchase_details/"+id,
            type : "POST",
            data : $('.form-bucket').serialize(),
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
        $('#totalItem').val($('.totalItem').text());
        $.ajax({
            url         : "purchase_details/loadForm/"+discount+"/"+$('.total').text(),
            type        : "GET",
            dataType    : "JSON",
            success     : function(data){
                $('#totalrp').val("Rp. "+data.totalrp);
                $('#payrp').val("Rp. "+data.payrp);
                $('#pay').val(data.pay);
                $('#show-pay').text("Rp. "+data.payrp);
                $('#show-spelling').text(data.spelling)
            },
            error       : function(){
                alert("Tidak dapat menampilkan data!");
            }
        });
    }
</script>

@endsection