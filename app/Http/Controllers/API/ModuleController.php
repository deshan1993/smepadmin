<?php

namespace App\Http\Controllers\API;
use App\Module;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class ModuleController extends Controller
{
    //insert module data
    public function addModule(Request $request){
      $validator = Validator::make($request->all(), [
        'moduleName' => 'required'
      ]);

      if($validator->fails()){
        return response()->json(['error'=>$validator->errors()], 401);
      }
      else{
        $table = new Module();
        $table->module_name = $request->moduleName;
        $table->save();

        if($table->save()){
          return response()->json("Successfully inserted");
        }
        else{
          return response()->json("Error occur");
        }
      }
    }

    //view module Data
    public function viewModule(){
      $data = DB::table('modules')->pluck('module_name');
      return response()->json($data);
    }

    //edit module
    public function updateModule(Request $request){
      $validator = Validator::make($request->all(), [
        'id' => 'required',
        'moduleName' => 'required'
      ]);

      if($validator->fails()){
        return response()->json(['error'=>$validator->errors()], 401);
      }
      else{
        $id = $request->input('id');
        $update = ['module_name' => $request->input('moduleName')];
        $data = DB::table('modules')->whereIn('id', [$id])->update($update);

        if($data){
          return response()->json("Successfully updated");
        }
        else{
          return response()->json("There is an error");
        }
      }
    }

    //delete modules
    public function deleteModule(Request $request){
      $validator = Validator::make($request->all(), [
        'id' => 'required'
      ]);

      if($validator->fails()){
        return response()->json(['error'=>$validator->errors()], 401);
      }
      else{
        $id = $request->input('id');
        $data1 = DB::select("SELECT id FROM modules WHERE id=:id",['id'=>$id]);
        if(count($data1)>0){
          $data = DB::table('modules')->WHERE('id', $id)->delete();

          if($data){
            return response()->json("Successfully deleted");
          }
          else{
            return response()->json("Error occured");
          }
        }
        else{
          return response()->json("Entered id can't be found");
        }

      }
    }
}
