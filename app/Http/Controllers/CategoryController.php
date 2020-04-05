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
        $category = Category::orderBy('category_id', 'asc')->get();
        $no = 0;
        $data = array();
        foreach ($category as $list) {
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = $list->category_name;
            $row[] = '<tr>
                    <div class="dropdown d-inline">
                      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Aksi
                      </button>
                      <div class="dropdown-menu">
                        <a onclick="editForm('.$list->category_id.')" class="dropdown-item has-icon"><i class="fas fa-edit"></i>Edit Data</a>
                        <a onclick="deleteData('.$list->category_id.')" class="deleteData dropdown-item has-icon"><i class="fas fa-trash"></i>Hapus Data</a>
                      </div>
                     </tr>';
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
