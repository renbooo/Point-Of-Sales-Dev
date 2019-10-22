<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Selling;
use App\Spending;

use PDF;

class ReportController extends Controller
{
   public function index()
   {
     $begin = date('Y-m-d', mktime(0,0,0, date('m'), 1, date('Y')));
     $end = date('Y-m-d');
     return view('report.index', compact('begin', 'end')); 
   }

   protected function getData($begin, $end){
     $no = 0;
     $data = array();
     $income = 0;
     $total_income = 0;
     while(strtotime($begin) <= strtotime($end)){
       $date = $begin;
       $begin = date('Y-m-d', strtotime("+1 day", strtotime($begin)));

       $total_selling = Selling::where('created_at', 'LIKE', "$date%")->sum('pay');
       $total_purchase = Purchase::where('created_at', 'LIKE', "$date%")->sum('pay');
       $total_spending = Spending::where('created_at', 'LIKE', "$date%")->sum('nominal');

       $income = $total_selling - $total_purchase - $total_selling;
       $total_income += $income;

       $no ++;
       $row = array();
       $row[] = $no;
       $row[] = indo_date($date, false);
       $row[] = currency_format($total_selling);
       $row[] = currency_format($total_purchase);
       $row[] = currency_format($total_spending);
       $row[] = currency_format($income);
       $data[] = $row;
     }
     $data[] = array("", "", "", "", "Total Pendapatan", currency_format($total_income));

     return $data;
   }

   public function listData($begin, $end)
   {   
     $data = $this->getData($begin, $end);

     $output = array("data" => $data);
     return response()->json($output);
   }

   public function refresh(Request $request)
   {
     $begin = $request['begin'];
     $end = $request['end'];
     return view('report.index', compact('begin', 'end')); 
   }

   public function exportPDF($begin, $end){
     $date_begin = $begin;
     $date_end = $end;
     $data = $this->getData($begin, $end);

     $pdf = PDF::loadView('report.pdf', compact('date_begin', 'date_end', 'data'));
     $pdf->setPaper('a4', 'potrait');
     
     return $pdf->stream();
   }
}