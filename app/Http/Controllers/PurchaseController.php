<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use App\Purchase;
use App\Supplier;
use App\PurchaseDetails;
use App\Product;

class PurchaseController extends Controller
{
	public function index(){
		$supplier = Supplier::all();
        return view('purchase.index', compact('supplier'));
    }
    public function listData(){
        $purchase = Purchase::leftJoin('supplier', 'supplier.supplier_id', '=', 'purchase.supplier_id')->orderBy('purchase.purchase_id', 'desc')->get();
        $no = 0;
        $data = array();
        foreach ($purchase as $list) {
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = indo_date(substr($list->created_at, 0, 10), false);
            $row[] = $list->supplier_name;
            $row[] = $list->total_item;
            $row[] = "Rp. ".currency_format($list->total_price);
            $row[] = $list->discount."%";
            $row[] = "Rp. ".currency_format($list->pay);
            $row[] = '<div class="dropdown d-inline">
                      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Aksi
                      </button>
                      <div class="dropdown-menu">
                        <a onclick="showDetail('.$list->purchase_id.')" class="dropdown-item has-icon"><i class="fas fa-eye"></i>Lihat Data</a>
                        <a onclick="deleteData('.$list->purchase_id.')" class="dropdown-item has-icon"><i class="fas fa-trash"></i>Hapus Data</a>
                      </div>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
    public function show($id){
        $detail = PurchaseDetails::leftJoin('product', 'product.product_code', '=', 'purchase_details.product_code')->where('purchase_id', '=', $id)->get();
        $no = 0;
        $data = array();
        foreach ($detail as $list) {
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = $list->product_code;
            $row[] = $list->product_name;
            $row[] = "Rp. ".currency_format($list->purchase_price);
            $row[] = $list->total;
            $row[] = "Rp. ".currency_format($list->purchase_price * $list->total);
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
    public function create($id){
        $purchase = new Purchase;
        $purchase->supplier_id = $id;
        $purchase->total_item = 0;
        $purchase->total_price = 0;
        $purchase->discount = 0;
        $purchase->pay = 0;
        $purchase->save();

        session(['purchase_id' => $purchase->purchase_id]);
        session(['supplier_id' => $id]);

        return Redirect::route('purchase_details.index');
    }
    public function store(Request $request){
        $purchase = Purchase::find($request['purchase_id']);
        $purchase->total_item = $request['total_item'];
        $purchase->total_price = $request['total'];
        $purchase->discount = $request['discount'];
        $purchase->pay = $request['pay'];
        $purchase->update();

        $detail = PurchaseDetails::where('purchase_id', '=', $request['purchase_id'])->get();
        foreach ($detail as $data) {
        	$product = Product::where('product_code', '=', $data->product_code)->first();
        	$product->product_stock += $data->total;
        	$product->update();
        }
        return Redirect::route('purchase.index');
    }
    public function destroy($id){
        $purchase = Purchase::find($id);
        $purchase->delete();

        $detail = PurchaseDetails::where('purchase_id', '=', $id)->get();
        foreach ($detail as $data) {
        	$product = Product::where('product_code', '=', $data->product_code)->first();
        	$product->stock -= $data->total;
        	$product->update();
        	$data->delete();
        }
    }    
}
