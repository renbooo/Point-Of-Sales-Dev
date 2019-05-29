<?php

namespace App\Http\Controllers;
use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(){
        return view('supplier.index');
    }
    public function listData(){
        $supplier = Supplier::orderBy('supplier_id', 'asc')->get();
        $no = 0;
        $data = array();
        foreach ($supplier as $list) {
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = $list->supplier_name;
            $row[] = $list->supplier_address;
            $row[] = $list->supplier_phone_number;
            $row[] = '<tr>
                     <a onclick="editForm('.$list->supplier_id.')" class="btn btn-warning btn-sm"><i class="material-icons">create</i></a>
                     <a onclick="deleteData('.$list->supplier_id.')" class="btn btn-danger btn-sm"><i class="material-icons">delete</i></a></tr>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
    public function store(Request $request){
        $supplier = new Supplier;
        $supplier->supplier_name = $request['supplier_name'];
		$supplier->supplier_address = $request['supplier_address'];
		$supplier->supplier_phone_number = $request['supplier_phone_number'];        
        $supplier->save();
    }
    public function edit($id){
        $supplier = Supplier::find($id);
        echo json_encode($supplier);
    }
    public function update(Request $request, $id){
        $supplier = Supplier::find($id);
        $supplier->supplier_name = $request['supplier_name'];
        $supplier->supplier_address = $request['supplier_address'];
        $supplier->supplier_phone_number = $request['supplier_phone_number'];
        $supplier->update();
    }
    public function destroy($id){
        $supplier = Supplier::find($id);
        $supplier->delete();
    }
}
