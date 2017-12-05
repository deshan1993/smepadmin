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
    public function index(){
        $institute = Institute::with('instituteUsers')->where('id', [14])->get();
        return response()->json($institute);
    }

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
    		'status' => 'required|boolean',
            'user_name' => 'required',
            'user_email' => 'required|email',
            'user_password' => 'required',
            'user_c_password' => 'required|same:user_password',
            'user_status' => 'required',
            'user_name_with_initials' => 'required',
            'user_gender' => 'required',
            'user_nic' => 'required',
            'user_mobile' => 'required',
            'user_designation' => 'required',
            'user_birthday' => 'required|date'
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
                $user_details = array(
                    'name' => $request->input('user_name'),
                    'email' => $request->input('user_email'),
                    'password' => bcrypt($request->input('user_password')),
                    'status' => $request->input('user_status'),
                    'name_with_initials' => $request->input('user_name_with_initials'),
                    'gender' => $request->input('user_gender'),
                    'nic' => $request->input('user_nic'),
                    'mobile' => $request->input('user_mobile'),
                    'designation' => $request->input('user_designation'),
                    'birthday' => $request->input('user_birthday'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'role_id' => 5
                );

                $insert_user_id = $table->users()->insertGetId($user_details);
                $id = array($insert_user_id); 
                $data = $table->instituteUsers()->attach($id);
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
    	//$editData = DB::table('institutes')->where('id', [$id])->get();
        $editData = Institute::with(
            array('instituteUsers' => function($query){
                $query->where('role_id', 5); 
            })
        )->where([['id', '=', $id],])->get();
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
    		'status' => 'required|boolean',
            'user_name' => 'required',
            'user_email' => 'required|email',
            'user_password' => 'required',
            'user_c_password' => 'required|same:user_password',
            'user_status' => 'required',
            'user_name_with_initials' => 'required',
            'user_gender' => 'required',
            'user_nic' => 'required',
            'user_mobile' => 'required',
            'user_designation' => 'required',
            'user_birthday' => 'required|date'
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
