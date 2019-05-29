<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use DataTables;
use PDF;

class ProductController extends Controller
{
    public function index(){
    	$category = Category::all();
    	return view('product.index', compact('category'));
    }

    public function listData(){
    	$product = Product::leftJoin('category', 'category.category_id', '=', 'product.category_id')->orderBy('product.product_id', 'desc')->get();
    	$no = 0;
    	$data = array();
    	foreach ($product as $list) {
    		$no ++;
            $row = array();
            $row[] = "<input type='checkbox' name='id[]'' id='ig_checkbox' value='".$list->product_id."'><label for='ig_checkbox'></label>";
            $row[] = $no;
            $row[] = $list->product_code;
            $row[] = $list->product_name;
            $row[] = $list->category_name;
            $row[] = $list->product_brand;
            $row[] = "Rp. ".currency_format($list->purchase_price);
            $row[] = "Rp. ".currency_format($list->selling_price);
            $row[] = $list->discount."%";
            $row[] = $list->product_stock;
            $row[] = '<tr>
                     <a onclick="editForm('.$list->product_id.')" class="btn btn-warning btn-sm"><i class="material-icons">create</i></a>
                     <a onclick="deleteData('.$list->product_id.')" class="btn btn-danger btn-sm"><i class="material-icons">delete</i></a></tr>';
            $data[] = $row;
    	}
    	return Datatables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request){
    	$total = Product::where('product_code', '=', $request['product_code'])->count();
    	if($total < 1){
    		$product = new Product;
    		$product->product_code = $request['product_code'];
    		$product->product_name = $request['product_name'];
    		$product->category_id = $request['category'];
    		$product->product_brand = $request['product_brand'];
    		$product->purchase_price = $request['purchase_price'];
    		$product->discount = $request['discount'];
    		$product->selling_price = $request['selling_price'];
    		$product->product_stock = $request['product_stock'];
    		$product->save();
    		echo json_encode(array('msg'=>'success'));
    	}else{
    		echo json_encode(array('msg'=>'error'));
    	}
    }

    public function edit($id){
    	$product = Product::find($id);
    	echo json_encode($product);
    }

    public function update(Request $request, $id){
    	$product = Product::find($id);
		$product->product_name = $request['product_name'];
		$product->category_id = $request['category'];
		$product->product_brand = $request['product_brand'];
		$product->purchase_price = $request['purchase_price'];
		$product->discount = $request['discount'];
		$product->selling_price = $request['selling_price'];
		$product->product_stock = $request['product_stock'];
		$product->update();
		echo json_encode(array('msg'=>'success'));
    }

    public function destroy($id){
    	$product = Product::find($id);
    	$product->delete();
    }

    public function deleteSelected(Request $request){
    	foreach ($request['id'] as $id) {
    		$product = Product::find($id);
    		$product->delete();
    	}
    }

    public function printBarcode(Request $request){
    	$data_product = array();
        if (is_array($request['id']) || is_object($request['id']))
        {
        	foreach ($request['id'] as $id) {
        		$product = Product::find($id);
        		$data_product[] = $product;
        	}
        }
    	$no = 1;
    	$pdf = PDF::loadView('product.barcode', compact('data_product', 'no'));
    	$pdf->setPaper('a4', 'potrait');
    	return $pdf->stream();
    }
}
