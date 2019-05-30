<?php

namespace App\Http\Controllers;
use App\Spending;
use Illuminate\Http\Request;
use DataTables;

class SpendingController extends Controller
{
    public function index(){
        return view('spending.index');
    }
    public function listData(){
        $spending = Spending::orderBy('spending_id', 'asc')->get();
        $no = 0;
        $data = array();
        foreach ($spending as $list) {
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = indo_date(substr($list->created_at, 0, 10), false);
            $row[] = $list->spending_type;
            $row[] = "Rp. " . currency_format($list->nominal);
            $row[] = '<tr>
                     <a onclick="editForm('.$list->spending_id.')" class="btn btn-warning btn-sm"><i class="material-icons">create</i></a>
                     <a onclick="deleteData('.$list->spending_id.')" class="btn btn-danger btn-sm"><i class="material-icons">delete</i></a></tr>';
            $data[] = $row;
        }
        return DataTables::of($data)->escapeColumns([])->make(true);
    }
    public function store(Request $request){
        $spending = new Spending;
        $spending->spending_type = $request['spending_type'];
        $spending->nominal = $request['nominal'];
        $spending->save();
    }
    public function edit($id){
        $spending = Spending::find($id);
        echo json_encode($spending);
    }
    public function update(Request $request, $id){
        $spending = Spending::find($id);
        $spending->spending_type = $request['spending_type'];
        $spending->nominal = $request['nominal'];
        $spending->update();
    }
    public function destroy($id){
        $spending = Spending::find($id);
        $spending->delete();
    }
}
