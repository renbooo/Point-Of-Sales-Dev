<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

use App\Setting;
use App\Category;
use App\Product;
use App\Supplier;
use App\Member;
use App\Selling;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $setting = Setting::find(1);

      $begin = date('Y-m-d', mktime(0,0,0, date('m'), 1, date('Y')));
      $end = date('Y-m-d');

      $date = $begin;
      $data_date = array();
      $data_income = array();

      while(strtotime($date) <= strtotime($end)){ 
        $data_date[] = (int)substr($date,8,2);
        
        $income = Selling::where('created_at', 'LIKE', "$date%")->sum('pay');
        $data_income[] = (int) $income;

        $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
      }
        
        $category = Category::count();
        $product = Product::count();
        $supplier = Supplier::count();
        $member = Member::count();

        if(Auth::user()->level == 1) return view('home.admin', compact('category', 'product', 'supplier', 'member', 'begin', 'end', 'data_income', 'data_date'));
        else return view('home.kasir', compact('setting'));
    }
}
