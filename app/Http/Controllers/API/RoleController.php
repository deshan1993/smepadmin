<?php

namespace App\Http\Controllers\API;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class RoleController extends Controller
{

    //function for insert roles
    public function insertRole(Request $request){
      $table = new Role();

      $validator = Validator::make($request->all(), [
           'name' => 'required'
       ]);

       if ($validator->fails()) {
         return response()->json(['error'=>$validator->errors()], 401);
       }
       else{
         $table->name = $request->input('name');

         $table->save();

         if($table->save()){
           return response()->json("Data saved");
         }
         else{
           return response()->json("Error occured");
         }
       }
    }

    //function for view roles
    public function viewRoles(){
      $data = DB::table('roles')->where('deleted', 0)->pluck('name');
      if(count($data)){
        return response()->json($data);
      }
      else{
        return response()->json("No data");
      }
      }

    //function for update the table
    public function updateRole(Request $request){

      $replaceName = $request->input('replaceName');

      $validator = Validator::make($request->all(), [
        'replaceName' => 'required'
      ]);

      if($validator->fails()){
        return response()->json(['error'=>$validator->errors()], 401);
      }
      else{
        $table = new Role();

        $update = [
          'name' => $replaceName
        ];

        $data = DB::table('roles')->whereIn('id', [5])->update($update);
        if(count($data)){
          return response()->json('Successfully updated');
        }
        else{
          return response()->json('Error occur');
        }
      }
    }

    //function for delete the role
    public function deleteRole(Request $request){

      $validator = Validator::make($request->all(), [
        'name' => 'required'
      ]);

      $update = [
        'deleted' => 1
      ];

      if($validator->fails()){
        return response()->json(['error'=>$validator->errors()], 401);
      }
      else{
        $name = $request->input('name');
        $data = DB::table('roles')->whereIn('name', [$name])->update($update);
      }

      if(count($data)){
        return response()->json("Successfully Deleted");
      }
      else{
        return respons()->json("Error occured");
      }
    }

    //function for enable disable
    public function updateStatus(Request $request){
      // 0 = disable, 1 = enable

      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'status' => 'required|boolean'
      ]);

      if($validator->fails()){
        return response()->json(['error'=>$validator->errors()], 401);
      }
      else{
        $name = $request->input('name');
        $status = $request->input('status');

        $update = ['status' => $status];

        $data = DB::table('roles')->whereIn('name', [$name])->update($update);
      }

      if(count($data)){
        if($status == 1){
          return response()->json("Successfully enble");
        }
        else{
          return response()->json("Successfully disable");
        }
      }
      else{
        return response()->json("Have an error with database");
      }
    }
}
