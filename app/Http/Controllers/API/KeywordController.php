<?php

namespace App\Http\Controllers\API;
use App\Keyword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use Validator;

class KeywordController extends Controller
{
    /**
    * @param array $request post data
    * @return message
    */
    public function insertKeyword(Request $request){
      $validator = Validator::make($request->all(), [
        'en_name' => 'required',
        'si_name' => 'required',
        'ta_name' => 'required'
      ]);
      if($validator->fails()){
        return response()->json(['error'=>$validator->errors()], 401);
      }
      else{
        $table = new Keyword();
        $table->en_name = $request->input('en_name');
        $table->si_name = $request->input('si_name');
        $table->ta_name = $request->input('ta_name');
        $table->save();
        if($table->save()){
          return response()->json(['success'=>'Successfully inserted']);
        }
        else{
          return response()->json(['error'=>'Error']);
        }
      }
    }

    /**
    * view keywords
    */
    public function viewKeyword(){
      $table = new Keyword();
      $data = DB::table('keywords')->get();
      if($data){
        return response()->json($data);
      }
      else{
        return reponse()->json(['error'=>'Error']);
      }
    }

    /**
    * @param id
    * @return data set or message
    */
    public function editKeyword($id){
      $data = DB::table('keywords')->where('id', $id)->get();
      if($data){
        return response()->json($data);
      }
      else{
        return response()->json(['error'=>'Error']);
      }
    }

    /**
    * @param array $request post data and id
    * @return message
    */
    public function updateKeyword(Request $request, $id){
      $validator = Validator::make($request->all(), [
        'en_name' => 'required',
        'si_name' => 'required',
        'ta_name' => 'required'
      ]);
      if($validator->fails()){
        return response()->json(['error'=>$validator->errors()], 401);
      }
      else{
        $update = [
          'en_name' => $request->input('en_name'),
          'si_name' => $request->input('si_name'),
          'ta_name' => $request->input('ta_name')
        ];
        $data = DB::table('keywords')->whereIn('id', [$id])->update($update);
        if($data){
          return response()->json(['success'=>'Successfully updated']);
        }
        else{
          return response()->json(['error'=>'Error']);
        }
      }
    }

    /**
    * @param id
    * @return message
    */
    public function deleteKeyword($id){
        $data = DB::table('keywords')->where('id', [$id])->delete();
        if($data){
          return response()->json(['success'=>'Successfully deleted']);
        }
        else{
          return response()->json(['error'=>'Error']);
        }
    }
}
