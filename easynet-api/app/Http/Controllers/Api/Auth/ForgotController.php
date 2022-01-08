<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\ForgotPasswordEmail;
use App\Models\User;
use App\Models\PasswordReset;
use Auth;

class ForgotController extends Controller
{
    public function forgot(Request $request)
    {

    	$validator = \Validator::make($request->all(), [
    		'email' => 'required|email'
    	]);

    	if($validator->fails()){
    		return response()->json($validator->errors(), 400);
    	}

    	
    	$email = $request->email;

        // Check if token already
        // $email_ready = PasswordReset::whereEmail($email)->first();
        // if($email_ready){
        //     return response()->json([
        //         'ready' => true,
        //         'message' => 'Your email has already to reset password',
        //         'data' => $email_ready
        //     ]);
        // }

    	$check = User::whereEmail($email)->first();
    	// var_dump($check); die;
    	if(!$check){
    		return response()->json([
    			'success' => false,
    			'message' => 'Oopss! User Not Registered'
    		]);	
    	}

    	$token = Str::random(10);

    	DB::table('password_resets')->insert([
    		'email'=> $email,
    		'token'=> $token
    	]);
    	
    	try{
    		$details = [
    			'title' => 'Reset password easynet website',
    			'url' => 'https://easynet.id',
    			'id' => $check->id,
    			'username' => $check->username,
    			'email' => $check->email,
    			'token' => $token
    		];
    		Mail::to($email)->send(new ForgotPasswordEmail($details));
    		return response()->json([
    			'success' => true,
    			'message' => 'Check your inbox email and follow the link to reset your password',
    			'data' => $check
    		]);
    	}catch(Exception $e){
    		return response()->json([
    			'success' => false,
    			'message' => $e->getMessage()
    		]);	
    	}
    }

    public function reset(Request $request)
    {
    	$validator = \Validator::make($request->all(), [
    		'token' => 'required',
    		'password' => 'required|min:10|confirmed'

    	]);

    	if($validator->fails()){
    		return response()->json($validator->errors(), 400);
    	}

    	$token = $request->token;
    	$password_reset = PasswordReset::whereToken($token)->first();
    	if(!$password_reset){
    		return response()->json([
    			'error_token' => true,
    			'message' => 'Token is not valid'
    		],400);
    	}

    	$user_reset = User::whereEmail($password_reset->email)->first();

    	if(!$user_reset){
    		return response()->json([
    			'error_email' => true,
    			'message' => "User does\'nt Exists"
    		],404);
    	}

    	$user_reset->password = Hash::make($request->password);
    	$user_reset->save();

    	try{
            
    		return response()->json([
    			'success' => true,
    			'message' => 'Ok!'.$user_reset->name.', your password has been updated',
    			'data' => $user_reset
    		]);
    	}catch(Exception $e){
    		return response()->json([
    			'success' => false,
    			'message' => "Error updated user password"
    		],404);
    	}
    	
    }

}
