<?php

namespace App\Http\Controllers\API;
use App\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthorController extends Controller
{
    //insert author
    public function insertAuthor(Request $request){
      $validator = Validator::make($request->all(), [
        'en_name' => 'required',
        'si_name' => 'required',
        'ta_name' => 'required'
      ]);

      if($validator->fails()){
        return response()->json(['error'=>$validator->errors()], 401);
      }
      else{
        $table = new Author();
        $table->en_name = $request->input('en_name');
        $table->si_name = $request->input('si_name');
        $table->ta_name = $request->input('ta_name');
        $table->save();
        if($table->save()){
          return response()->json(['success'=>"Inserted successfully"]);
        }
        else{
          return response()->json(['error'=>"Error occured"]);
        }
      }
    }

    //view author
    public function viewAuthor(){
      $table = new Author();
      $data = DB::table('authors')->pluck('name');
      return response()->json($data);
    }

    //update author details
    public function updateAuthor(Request $request){
      $validator = Validator::make($request->all(), [
        'id' => 'required',
        'name' => 'required'
      ]);
      if($validator->fails()){
        return response()->json(['error'=>$validator->errors()], 401);
      }
      else{
        $id = $request->input('id');
        $update = ['name' => $request->input('name')];
        $data = DB::table('authors')->whereIn('id', [$id])->update($update);
        if($data){
          return response()->json("Successfully updated");
        }
        else{
          return reponse()->json("There is an error");
        }
      }
    }

    //delete authors
    public function deleteAuthor(Request $request){
      $validator = Validator::make($request->all(), [
        'id' => 'required'
      ]);
      if($validator->fails()){
        return response()->json(['error'=>$request->errors()], 401);
      }
      else{
        $id = $request->input('id');
        $data = DB::table('authors')->whereIn('id', [$id])->delete();

        if($data){
          return response()->json("Successfully deleted");
        }
        else{
          return response()->json("There is an error");
        }
      }
    }
}
