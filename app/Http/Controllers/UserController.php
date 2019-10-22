<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\User;
use Hash;
use Auth;

class UserController extends Controller
{
    public function index(){
        return view('user.index');
    }
    public function listData(){
        $user = User::where('level', '!=', 1)->orderBy('id', 'desc')->get();
        $no = 0;
        $data = array();
        foreach ($user as $list) {
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = $list->name;
            $row[] = $list->email;
            $row[] = '<tr>
                     <div class="dropdown d-inline">
                      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Aksi
                      </button>
                      <div class="dropdown-menu">
                        <a onclick="editForm('.$list->id.')" class="dropdown-item has-icon"><i class="fas fa-edit"></i>Edit Data</a>
                        <a onclick="deleteData('.$list->id.')" class="dropdown-item has-icon"><i class="fas fa-trash"></i>Hapus Data</a>
                      </div></tr>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
    public function store(Request $request){
        $user = new User;
    	$user->name = $request['name'];
        $user->email = $request['email'];
		$user->password = bcrypt($request['password']);
		$user->level = 2;
		$user->photos = "user.png";       
        $user->save();
    }
    public function edit($id){
        $user = User::find($id);
        echo json_encode($user);
    }
    public function update(Request $request, $id){
        $user = User::find($id);
        $user->name = $request['name'];
        $user->email = $request['email'];
        if (!empty($request['password'])) $user->password = bcrypt($request['password']);
        	$user->update();        	
    }
    public function destroy($id){
        $user = User::find($id);
        $user->delete();
    }
    public function show(){
    	$user = Auth::user();
    	return view('user.profile', compact('user'));
    }
    public function changeProfile(Request $request, $id){
    	$msg = "success";
    	$user = User::find($id);
    	if (!empty($request['password'])) {
    		if (Hash::check($request['old_password'], $user->password)) {
    			$user->password = bcrypt($request['password']);
    		}else{
    			$msg = 'error';
    		}
    	}
    	if ($request->hasFile('photos')) {
    		$file = $request->file('photos');
    		$image_name = "user_photo ".$id.".".$file->getClientOriginalExtension();
    		$locate = public_path('images');

    		$file->move($locate, $image_name);
    		$user->photos = $image_name;
    		$data_image = $image_name;
    	}else{
    		$data_image = $user->photos;
    	}
    	$user->update();
    	echo json_encode(array('msg'=>$msg, 'url'=>asset('images/'.$data_image)));
    }
}
