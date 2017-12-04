<?php

namespace App\Http\Controllers\API;

use App\Institute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class InstituteController extends Controller
{
    /**
    * @param array $request post data
    * @return message
    */
    public function insertInstitute(Request $request){
    	$validator = Validator::make($request->all(), [
    		'name' => 'required',
    		'registration_number' => 'required',
    		'registered_date' => 'required|date',
    		'contact_number' => 'required|numeric',
    		'email' => 'required|email',
    		'address' => 'required',
    		'status' => 'required|boolean'
    	]);
    	if($validator->fails()){
    		return response()->json(['error'=>$validator->errors()], 401);
    	}
    	else{
    		$table = new Institute();
    		$table->name = $request->input('name');
    		$table->registration_number = $request->input('registration_number');
    		$table->registered_date = $request->input('registered_date');
    		$table->contact_number = $request->input('contact_number');
    		$table->email = $request->input('email');
    		$table->address = $request->input('address');
    		$table->status = $request->input('status');
    		$table->save();

    		if($table->save()){
    			return response()->json(['success'=>'Successfully inserted']);
    		}
    		else{
    			return response()->json(['error'=>'Error occured']);
    		}
    	}
    }

    /**
    * @return dataset or message
    */
    public function viewInstitute(){
    	$table = new Institute();
    	$viewData = DB::table('institutes')->where('deleted', 0)->get();
    	if($viewData){
    		return response()->json($viewData);
    	}
    	else{
    		return response()->json(['error'=>'Error occured']);
    	}
    }

    /**
    * @param get id data
    * @return dataset or message
    */
    public function editInstitute($id){
    	$editData = DB::table('institutes')->where('id', [$id])->get();
    	if($editData){
    		return response()->json($editData);
    	}
    	else{
    		return response()->json(['error'=>'Error occured']);
    	}
    }

    /**
    * @param $request post data and get id
    * @return dataset or message
    */
    public function updateInstitute(Request $request, $id){
    	$validator = Validator::make($request->all(), [
    		'name' => 'required',
    		'registration_number' => 'required',
    		'registered_date' => 'required|date',
    		'contact_number' => 'required|numeric',
    		'email' => 'required|email',
    		'address' => 'required',
    		'status' => 'required|boolean'
    	]);
    	if($validator->fails()){
    		return response()->json(['error'=>$validator->errors()], 401);
    	}
    	else{
    		$update = [
    			'name' => $request->input('name'),
    			'registration_number' => $request->input('registration_number'),
    			'registered_date' => $request->input('registered_date'),
    			'contact_number' => $request->input('contact_number'),
    			'email' => $request->input('email'),
    			'address' => $request->input('address'),
    			'status' => $request->input('status')
    		];

    		$updateData = DB::table('institutes')->whereIn('id', [$id])->update($update);

    		if($updateData){
    			return response()->json(['success'=>'Successfully updated']);
    		}
    		else{
    			return response()->json(['error'=>'Error occured']);
    		}
    	}
    }

    /**
    * @param get id
    * @return message
    */
    public function deleteInstitute($id){
    	$update = ['deleted' => 1];
    	$deleteInstitute = DB::table('institutes')->whereIn('id', [$id])->update($update);
    	if($deleteInstitute){
    		return response()->json(['success'=>'Successfully deleted']);
    	}
    	else{
    		return response()->json(['error'=>'Error occured'], 401);
    	}
    }

    /**
    * @param get id and status data
    * @return message
    */
    public function statusInstitute($id, $status){
    	$update = ['status' => $status];
    	$updateStatus = DB::table('institutes')->whereIn('id', [$id])->update($update);
    	if($updateStatus){
    		if($status == 1){
    			return response()->json(['success'=>'Successfully enabled']);
    		}
    		else{
    			return response()->json(['success'=>'Successfully disabled']);
    		}
    	}
    	else{
    		return response()->json(['error'=>'Error ocured']);
    	}
    }
}
