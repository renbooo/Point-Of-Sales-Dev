<?php

namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
    	return view('category.index');
    }
    public function listData(){
    	$category = Category::orderBy('category_id', 'desc')->get();
    	$no = 0;
    	$data = array();
    	foreach ($category as $list) {
    		$no++;
    		$row = array();
    		$row[] = $no;
    		$row[] = $list->category_name;
    		$row[] = '<div> class="btn group">
    				 <a onclick="editForm('.$list->category_id.')" class="btn btn-primary btn-sm"></a>
    				 <a onclick="deleteData('.$list->category_id.')" class="btn btn-danger btn-sm"></a></div>';
    		$data[] = $row;
    	}
    	$output = array("data" => $data);
    	return response()->json($output);
    }
    public function store(Request $request){
    	$category = new Category;
    	$category->category_name = $request['category_name'];
    	$category->save();
    }
    public function edit($id){
    	$category = Category::find($id);
    	echo json_encode($category);
    }
    public function update(Request $request, $id){
    	$category = Category::find($id);
    	$category->category_name = $request['category_name'];
    	$category->update();
    }
    public function destroy($id){
    	$category = Category::find($id);
    	$category->delete();
    }
}
