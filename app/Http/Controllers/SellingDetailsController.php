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
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;

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
        $connector = new FilePrintConnector("php://stdout");
        $printer = new Printer($connector);
        $center = Printer::JUSTIFY_CENTER;
        $right = Printer::JUSTIFY_RIGHT;
        $left = Printer::JUSTIFY_LEFT;
        $printer->setJustification($center);
        $printer->text($setting->company_name . "\n");

        $printer->setJustification($center);
        $printer->text($setting->company_address . "\n");
        $printer->setJustification($left);        
        $printer->text(date('Y-m-d'));
        $printer->setJustification($right);
        $printer->text(substr(Auth::user()->name . "\n", -15));
        $printer->setJustification($left);
        $printer->text("No : ".substr("00000000".$selling->selling_id . "\n", -8));
        $printer->setJustification($center);
        $printer->text("============================ \n");
        
        foreach($detail as $list){
          $printer->setJustification($left);
          $printer->text($list->product_code);
          $printer->setJustification($right);
          $printer->text($list->product_name. "\n"); 
          $printer->setJustification($left);
          $printer->text($list->total." x ".currency_format($list->selling_price));
          $printer-> setJustification($right);
          $printer-> text(substr("                ".currency_format($list->selling_price*$list->total) . "\n", -10));           
        
          if($list->discount != 0){
              $printer->setJustification($left);
              $printer->text("Diskon", 0);
              $printer->setJustification($right);
              $printer->text(substr("                      -".currency_format($list->discount/100*$list->sub_total). "\n", -10));
          }
        }


        $printer->setJustification($center);
        $printer->text("---------------------------- \n", 0);

        $printer->setJustification($left);
        $printer->text("Total Harga: ", 0);
        $printer->setJustification($right);
        $printer->text(substr("           ".currency_format($selling->total_price). "\n", -10));

        $printer->setJustification($left);
        $printer->text("Total Item: ", 0);
        $printer->setJustification($right);
        $printer->text(substr("           ".$selling->total_item . "\n", -10));

        $printer->setJustification($left);
        $printer->text("Diskon Member: ", 0);
        $printer->setJustification($right);
        $printer->text(substr("           ".$selling->discount."% \n", -10));

        $printer->setJustification($left);
        $printer->text("Total Bayar: ", 0);
        $printer->setJustification($right);
        $printer->text(substr("            ".currency_format($selling->pay) . "\n", -10));

        $printer->setJustification($left);
        $printer->text("Diterima: ", 0);
        $printer->setJustification($right);
        $printer->text(substr("            ".currency_format($selling->received) . "\n", -10));

        $printer->setJustification($left);
        $printer->text("Kembali: ", 0);
        $printer->setJustification($right);
        $printer->text(substr("            ".currency_format($selling->received-$selling->pay) . "\n", -10));
        
        $printer->setJustification($center);
        $printer->text("============================ \n", 0);
        $printer->setJustification($center);
        $printer->text("-= TERIMA KASIH =-", 250);
        
        $printer->setJustification();
        $printer->cut();
        $printer->close();
      }
       
      return view('selling_details.success', compact('setting'));
   }

   public function notePDF(){
     $detail = SellingDetails::leftJoin('product', 'product.product_code', '=', 'selling_details.product_code')->where('selling_id', '=', session('selling_id'))->get();

      $selling = Selling::find(session('selling_id'));
      $setting = Setting::find(1);
      $no = 0;
     
     $pdf = PDF::loadView('selling_details.notepdf', compact('detail', 'selling', 'setting', 'no'));
     $pdf->setPaper(array(0,0,550,440), 'potrait');      
      return $pdf->stream();
   }
}
