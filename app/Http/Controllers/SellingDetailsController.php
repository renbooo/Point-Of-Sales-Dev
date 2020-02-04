<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Auth;
use PDF;
use App\Selling;
use App\Product;
use App\Member;
use App\Setting;
use App\SellingDetails;

class SellingDetailsController extends Controller
{
   public function index(){
      $product = Product::all();
      $member = Member::all();
      $setting = Setting::first();

     if(!empty(session('selling_id'))){
       $selling_id = session('selling_id');
       return view('selling_details.index', compact('product', 'member', 'setting', 'selling_id'));
     }else{
       return Redirect::route('home');  
     }
   }

   public function listData($id)
   {
   
     $detail = SellingDetails::leftJoin('product', 'product.product_code', '=', 'selling_details.product_code')->where('selling_id', '=', $id)->get();
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
       $row[] = "Rp. ".currency_format($list->selling_price);
       $row[] = "<input type='number' class='form-control' name='total_$list->selling_details_id' value='$list->total' onChange='changeCount($list->selling_details_id)'>";
       $row[] = $list->discount."%";
       $row[] = "Rp. ".currency_format($list->sub_total);
       $row[] = '<div class="btn-group">
               <a onclick="deleteItem('.$list->selling_details_id.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
       $data[] = $row;

       $total += $list->selling_price * $list->total;
       $total_item += $list->total;
     }

     $data[] = array("<span class='d-none total'>$total</span><span class='d-none total_item'>$total_item</span>", "", "", "", "", "", "", "");
    
     $output = array("data" => $data);
     return response()->json($output);
   }

   public function store(Request $request)
   {
        $product = Product::where('product_code', '=', $request['product_code'])->first();
        $detail = new SellingDetails;
        $detail->selling_id = $request['selling_id'];
        $detail->product_code = $request['product_code'];
        $detail->selling_price = $product->selling_price;
        $detail->total = 1;
        $detail->discount = $product->discount;
        $detail->sub_total = $product->selling_price - ($product->discount/100 * $product->selling_price);
        $detail->save();

   }

   public function update(Request $request, $id)
   {
      $input_name = "total_".$id;
      $detail = SellingDetails::find($id);
      $total_price = $request[$input_name] * $detail->selling_price;

      $detail->total = $request[$input_name];
      $detail->sub_total = $total_price - ($detail->discount/100 * $total_price);
      $detail->update();
   }

   public function destroy($id)
   {
      $detail = SellingDetails::find($id);
      $detail->delete();
   }

   public function newSession()
   {
      $selling = new Selling; 
      $selling->member_code = 0;    
      $selling->total_item = 0;    
      $selling->total_price = 0;    
      $selling->discount = 0;    
      $selling->pay = 0;    
      $selling->received = 0;    
      $selling->users_id = Auth::user()->id;    
      $selling->save();
      
      session(['selling_id' => $selling->selling_id]);

      return Redirect::route('transaction.index');    
   }

   public function saveData(Request $request)
   {
      $selling = Selling::find($request['selling_id']);
      $selling->member_code = $request['member_code'];
      $selling->total_item = $request['total_item'];
      $selling->total_price = $request['total'];
      $selling->discount = $request['discount'];
      $selling->pay = $request['pay'];
      $selling->received = $request['received'];
      $selling->update();

      $detail = SellingDetails::where('selling_id', '=', $request['selling_id'])->get();
      foreach($detail as $data){
        $product = Product::where('product_code', '=', $data->product_code)->first();
        $product->product_stock -= $data->total;
        $product->update();
      }
      return Redirect::route('transaction.print');
   }
   
   public function loadForm($discount, $total, $received){
     $pay = $total - ($discount / 100 * $total);
     $remaining = ($received != 0) ? $received - $pay : 0;

     $data = array(
        "total_rp" => currency_format($total),
        "pay" => $pay,
        "pay_rp" => currency_format($pay),
        "spelling" => ucwords(spelling($pay))." Rupiah",
        "remaining_rp" => currency_format($remaining),
        "remaining_spelling" => ucwords(spelling($remaining))." Rupiah"
      );
     return response()->json($data);
   }

   public function printNote()
   {
      $detail = SellingDetails::leftJoin('product', 'product.product_code', '=', 'selling_details.product_code')
        ->where('selling_id', '=', session('selling_id'))
        ->get();

      $selling = Selling::find(session('selling_id'));
      $setting = Setting::find(1);
      
      if($setting->note_type == 0){
        $handle = printer_open(); 
        printer_start_doc($handle, "Nota");
        printer_start_page($handle);

        $font = printer_create_font("Consolas", 100, 80, 600, false, false, false, 0);
        printer_select_font($handle, $font);
        
        printer_draw_text($handle, $setting->company_name, 400, 100);

        $font = printer_create_font("Consolas", 72, 48, 400, false, false, false, 0);
        printer_select_font($handle, $font);
        printer_draw_text($handle, $setting->company_address, 50, 200);

        printer_draw_text($handle, date('Y-m-d'), 0, 400);
        printer_draw_text($handle, substr("             ".Auth::user()->name, -15), 600, 400);

        printer_draw_text($handle, "No : ".substr("00000000".$selling->selling_id, -8), 0, 500);

        printer_draw_text($handle, "============================", 0, 600);
        
        $y = 700;
        
        foreach($detail as $list){           
           printer_draw_text($handle, $list->product_code." ".$list->product_name, 0, $y+=100);
           printer_draw_text($handle, $list->total." x ".currency_format($list->selling_price), 0, $y+=100);
           printer_draw_text($handle, substr("                ".currency_format($list->selling_price*$list->total), -10), 850, $y);

           if($list->discount != 0){
              printer_draw_text($handle, "Diskon", 0, $y+=100);
              printer_draw_text($handle, substr("                      -".currency_format($list->discount/100*$list->sub_total), -10),  850, $y);
           }
        }
        
        printer_draw_text($handle, "----------------------------", 0, $y+=100);

        printer_draw_text($handle, "Total Harga: ", 0, $y+=100);
        printer_draw_text($handle, substr("           ".currency_format($selling->total_price), -10), 850, $y);

        printer_draw_text($handle, "Total Item: ", 0, $y+=100);
        printer_draw_text($handle, substr("           ".$selling->total_item, -10), 850, $y);

        printer_draw_text($handle, "Diskon Member: ", 0, $y+=100);
        printer_draw_text($handle, substr("           ".$selling->discount."%", -10), 850, $y);

        printer_draw_text($handle, "Total Bayar: ", 0, $y+=100);
        printer_draw_text($handle, substr("            ".currency_format($selling->pay), -10), 850, $y);

        printer_draw_text($handle, "Diterima: ", 0, $y+=100);
        printer_draw_text($handle, substr("            ".currency_format($selling->received), -10), 850, $y);

        printer_draw_text($handle, "Kembali: ", 0, $y+=100);
        printer_draw_text($handle, substr("            ".currency_format($selling->received-$selling->pay), -10), 850, $y);
        

        printer_draw_text($handle, "============================", 0, $y+=100);
        printer_draw_text($handle, "-= TERIMA KASIH =-", 250, $y+=100);
        printer_delete_font($font);
        
        printer_end_page($handle);
        printer_end_doc($handle);
        printer_close($handle);
      }
       
      return view('selling_details.success', compact('setting'));
   }

   public function notePDF(){
     $detail = SellingDetails::leftJoin('product', 'product.product_code', '=', 'selling_details.product_code')
        ->where('selling_id', '=', session('selling_id'))
        ->get();

      $selling = Selling::find(session('selling_id'));
      $setting = Setting::find(1);
      $no = 0;
     
     $pdf = PDF::loadView('selling_details.notepdf', compact('detail', 'selling', 'setting', 'no'));
     $pdf->setPaper(array(0,0,550,440), 'potrait');      
      return $pdf->stream();
   }
}
