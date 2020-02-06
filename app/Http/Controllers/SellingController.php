<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Redirect;
use App\Selling;
use App\Product;
use App\Member;
use App\SellingDetails;

class SellingController extends Controller
{
    public function index(){
        return view('selling.index');
    }
    public function listData(){
        $selling = Selling::leftJoin('users', 'users.id', '=', 'selling.users_id')->select('users.*', 'selling.*', 'selling.created_at as date')->orderBy('selling.selling_id', 'desc')->get();
        $no = 0;
        $data = array();
        foreach ($selling as $list) {
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = indo_date(substr($list->date, 0, 10), false);
            $row[] = $list->member_code;
            $row[] = $list->total_item;
            $row[] = "Rp. ".currency_format($list->total_price);
            $row[] = $list->discount."%";
            $row[] = "Rp. ".currency_format($list->pay);
            $row[] = $list->name;
            $row[] = '<tr>
                     <div class="dropdown d-inline">
                      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Aksi
                      </button>
                      <div class="dropdown-menu">
                        <a onclick="showDetail('.$list->selling_id.')" class="dropdown-item has-icon"><i class="fas fa-eye"></i>Lihat Data</a>
                        <a onclick="deleteData('.$list->selling_id.')" class="dropdown-item has-icon"><i class="fas fa-trash"></i>Hapus Data</a>
                      </div></tr>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
    public function show($id){
        $detail = SellingDetails::leftJoin('product', 'product.product_code', '=', 'selling_details.product_code')->where('selling_id', '=', $id)->get();
        $no = 0;
        $data = array();
        foreach ($detail as $list) {
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = $list->product_code;
            $row[] = $list->product_name;
            $row[] = "Rp. ".currency_format($list->selling_price);
            $row[] = $list->total;
            $row[] = "Rp. ".currency_format($list->sub_total);
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
    public function destroy($id){
        $selling = Selling::find($id);
        $selling->delete();

        $detail = SellingDetails::where('selling_id', '=', $id)->get();
        foreach ($detail as $data) {
        	$product = Product::where('product_code', '=', $data->product_code)->first();
        	$product->stock += $data->total;
        	$data->update();
        	$data->delete();
        }
    }
}
