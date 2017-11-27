<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Consumer as Consumer;
use Illuminate\Support\Facades\Auth;
use Validator;

class ConsumerController extends Controller
{
    public function index(){
        $consumer = Consumer::with('modules')->get();
        return response()->json($consumer);        
    }
}