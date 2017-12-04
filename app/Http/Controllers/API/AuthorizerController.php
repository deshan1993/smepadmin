<?php

namespace App\Http\Controllers\API;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class AuthorizerController extends Controller
{	
	/**
	* @param array $request post data
	* @return message
	*/
    public function insertAuthorizer(Request $request){

    	$validator = Validator::make($request->all(), [
    		'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'status'=>'required|boolean',
            'deleted'=>'required|boolean',
            'name_with_initials'=>'required',
            'gender'=>'required',
            'nic'=>'required',
            'mobile'=>'required',
            'designation'=>'required',
            'birthday'=>'required',
            'highest_qualification' => 'required',
            'highest_university' => 'required',
            'highest_grade' => 'required',
            'highest_year' => 'required',
            'country_id' => 'required'
    	]);

    	if($validator->fails()){
    		return response()->json(['error'=>$validator->errors()], 401);
    	}
    	else{

    		$role_id = 4;
    		$user_table = new User();

    		$user_table->name = $request->input('name');
    		$user_table->email = $request->input('email');
    		$user_table->password = bcrypt($request->input('password'));
    		$user_table->name_with_initials = $request->input('name_with_initials');
    		$user_table->gender = $request->input('gender');
    		$user_table->nic = $request->input('nic');
    		$user_table->mobile = $request->input('mobile');
    		$user_table->designation = $request->input('designation');
    		$user_table->birthday = $request->input('birthday');
    		$user_table->role_id = $role_id;
    		$user_table->save();

    		$highest_edu_quali = array(
    			['user_id' => $user_table->id,
    			'qualification'=> $request->input('highest_qualification'),
    			'university' => $request->input('highest_university'),
    			'grade' => $request->input('highest_grade'),
    			'year' => $request->input('highest_year'),
    			'country_id' => $request->input('country_id'),
    			'created_at' => now(),
    			'updated_at' => now()]
    		);

    		$proff_edu_quali = array(
    			[	'user_id' => $user_table->id,
    				'qualification' => 'MSC',
    				'university' => 'colombo uni',
    				'grade' => 'A',
    				'year' => 2015,
    				'created_at' => now(),
    				'updated_at' => now(),
    				'country_id' => 10
    			],
    			[	'user_id' => $user_table->id,
    				'qualification' => 'MSC1',
    				'university' => 'moratuwa uni',
    				'grade' => 'A',
    				'year' => 2017,
    				'created_at' => now(),
    				'updated_at' => now(),
    				'country_id' => 10
    			]
    		);

    		$subject_area = array(1,2);

    		if($user_table->save()){
    			$insert_highest_quali = $user_table->highestEducation()->insert($highest_edu_quali);
    			$insert_proff_quali = $user_table->professionalEducations()->insert($proff_edu_quali);
    			$insert_subject_areas = $user_table->subjectAreas()->attach($subject_area);
    			return response()->json(['success'=>'Successfully inserted']);
    		}
    		else{
    			return response()->json(['error'=>'Error occured'], 401);
    		}
    	}
    }
}
