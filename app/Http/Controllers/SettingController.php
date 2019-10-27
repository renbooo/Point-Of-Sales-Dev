<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingController extends Controller
{
   public function index()
   {
      return view('setting.index'); 
   }

   public function edit($id)
   {
     $setting = Setting::find($id);
     echo json_encode($setting);
   }

   public function update(Request $request, $id)
   {
      $setting = Setting::find($id);
      $setting->company_name = $request['company_name'];
      $setting->company_address = $request['company_address'];
      $setting->company_phone_number = $request['company_phone_number'];
      $setting->member_discount = $request['member_discount'];
      $setting->note_type = $request['note_type'];
      
      if ($request->hasFile('company_logo')) {
         $file = $request->file('company_logo');
         $image_name = "company_logo.".$file->getClientOriginalExtension();
         $location = public_path('images');

         $file->move($location, $image_name);
         $setting->company_logo = $image_name;  
      }

      if ($request->hasFile('member_card')) {
         $file = $request->file('member_card');
         $image_name = "member_card.".$file->getClientOriginalExtension();
         $location = public_path('images');

         $file->move($location, $image_name);
         $setting->member_card = $image_name;  
      }
      $setting->update();
   }

}