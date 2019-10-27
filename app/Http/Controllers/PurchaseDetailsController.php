<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use App\Purchase;
use App\Supplier;
use App\Product;
use App\PurchaseDetails;

class PurchaseDetailsController extends Controller
{
	public function index(){
		$product = Product::all();
		$purchase_id = session('purchase_id');
		$supplier = Supplier::find(session('supplier_id'));
        return view('purchase_details.index', compact('product', 'purchase_id', 'supplier'));
    }
    public function listData($id){
        $detail = PurchaseDetails::leftJoin('product', 'product.product_code', '=', 'purchase_details.product_code')->where('purchase_id', '=', $id)->get();
        $no = 0;
        $data = array();
        $total = 0;
        $total_item = 0;
        foreach($detail as $list){
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = $list->product_code;
            $row[] = $list->product_name;
            $row[] = "Rp. ".currency_format($list->purchase_price);
            $row[] = "<input type='number' class='form-control' name='total_$list->purchase_details_id' value='$list->total' onChange='changeCount($list->purchase_details_id)'>";
            $row[] = "Rp. ".currency_format($list->purchase_price * $list->total);
            $row[] = '<a onclick="deleteItem('.$list->purchase_details_id.')" class="btn btn-danger btn-sm"><i class="fas fa-trash text-white"></i></a>';
            $data[] = $row;

            $total += $list->purchase_price * $list->total;
            $total_item += $list->total;
        }
        $data[] = array("<span class='d-none total'>$total</span><span class='d-none total_item'>$total_item</span>", "", "", "", "", "", "");
        $output = array("data"=>$data);
        return response()->json($output);
    }
    public function store(Request $request){
    	$product = Product::where('product_code', '=', $request['product_code'])->first();
        $detail = new PurchaseDetails;
        $detail->purchase_id = $request['purchase_id'];
        $detail->product_code = $request['product_code'];
        $detail->purchase_price = $product->purchase_price;
        $detail->total = 1;
        $detail->sub_total = $product->purchase_price;
        $detail->save();
    }
    public function update(Request $request, $id){
        $input_name = "total_". $id;
        $detail = PurchaseDetails::find($id);
        $detail->total = $request[$input_name];
        $detail->sub_total = $detail->purchase_price*$request[$input_name];
        $detail->update();
    }
    public function destroy($id){
    	$detail = PurchaseDetails::find($id);
    	$detail->delete();
    }
    public function loadForm($discount, $total){
    	$pay = $total - ($discount/100*$total);
    	$data = array(
    	    "total_rp"  => currency_format($total),
    	    "pay"      => $pay,
    	    "pay_rp"    => currency_format($pay),
    	    "spelling" => ucwords(spelling($pay))." Rupiah"
    	);
    	return response()->json($data);
    }    
}
