<?php

namespace App\Http\Controllers;
use App\Member;
use PDF;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(){
        return view('member.index');
    }
    public function listData(){
        $member = Member::orderBy('member_id', 'asc')->get();
        $no = 0;
        $data = array();
        foreach ($member as $list) {
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = $list->member_code;
            $row[] = $list->member_name;
            $row[] = $list->member_address;
            $row[] = $list->member_phone_number;
            $row[] = '<tr>
                     <a onclick="editForm('.$list->member_id.')" class="btn btn-warning btn-sm"><i class="material-icons">create</i></a>
                     <a onclick="deleteData('.$list->member_id.')" class="btn btn-danger btn-sm"><i class="material-icons">delete</i></a></tr>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
    public function store(Request $request){
        $total = Member::where('member_code', '=', $request['member_code'])->count();
        if ($total < 1) {
        	$member = new Member;
        	$member->member_code = $request['member_code'];
	        $member->member_name = $request['member_name'];
			$member->member_address = $request['member_address'];
			$member->member_phone_number = $request['member_phone_number'];        
	        $member->save();
	        echo json_encode(array('msg'=>'success'));
        }else{
        	echo json_encode(array('msg'=>'error'));
        }
    }
    public function edit($id){
        $member = Member::find($id);
        echo json_encode($member);
    }
    public function update(Request $request, $id){
        $member = Member::find($id);
        $member->member_name = $request['member_name'];
        $member->member_address = $request['member_address'];
        $member->member_phone_number = $request['member_phone_number'];
        $member->update();
        echo json_encode(array('msg'=>'success'));
    }
    public function destroy($id){
        $member = Member::find($id);
        $member->delete();
    }
}
