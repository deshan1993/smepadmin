<?php

namespace App\Http\Controllers\API;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class CategoryController extends Controller
{
    //insert categories
    public function insertCategory(Request $request){
      $validator = Validator::make($request->all(), [
        'en_name' => 'required',
        'si_name' => 'required',
        'ta_name' => 'required'
      ]);
      if($validator->fails()){
        return response()->json(['error'=>$request->errors()], 401);
      }
      else{
        $table = new Category();
        $table->en_name = $request->input('en_name');
        $table->si_name = $request->input('si_name');
        $table->ta_name = $request->input('ta_name');
        $table->save();
        if($table->save()){
          return response()->json(['success'=>"New category was inserted successfully"]);
        }
        else{
          return response()->json(['error'=>"There is an error"]);
        }
      }
    }

    //view Category
    public function viewCategory(){
      $table = new Category();
      $data = DB::table('categories')->pluck('description','name');
      return response()->json($data);
    }

    //update Category
    public function updateCategory(Request $request){
      $validator = Validator::make($request->all(), [
        'id' => 'required',
        'name' => 'required',
        'description' => 'required'
      ]);

      if($validator->fails()){
        return response()->json(['error'=>$validator->errors()], 401);
      }
      else{
        $id = $request->input('id');
        $update = [
          'name' => $request->input('name'),
          'description' => $request->input('description')
        ];
        $data = DB::table('categories')->whereIn('id', [$id])->update($update);
        if($data){
          return response()->json("Update successfully");
        }
        else{
          return response()->json("There is an error");
        }
      }
    }

    //delete Category
    public function deleteCategory(Request $request){
      $validator = Validator::make($request->all(), [
        'id' => 'required'
      ]);

    if($validator->fails()){
      return response()->json(['error'=>$request->errors()], 401);
    }
    else{
      $data = DB::table('categories')->where('id', [$request->input('id')])->delete();
      if($data){
        return response()->json("Updated successfully");
      }
      else{
        return response()->json("There is an error");
      }
    }
  }
}
