<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\MikrotikRouter;

use App\MyMethod\RouterosAPI;

class MyMikrotikRouterController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function($request, $next){

        if(Gate::allows('router-os')) return $next($request);
            abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }


    public function connecting_router(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ip' => 'required',
            'user' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $API = new RouterosAPI();
        $ip = $request->ip;
        $user = $request->user;
        $password = $request->password;
        if ($API->connect($ip, $user, $password)) {
            $identity = $API->comm('/system/identity/print');
            $check_router = MikrotikRouter::where('identity', $identity[0]['name'])->get();
            // echo $check_router[0]->connect;
            // echo count($check_router);
            // var_dump($check_router); die;
            if(count($check_router) % 2 == 1) {
            	if($check_router[0]->connect === 0){
            		$new_connect = MikrotikRouter::findOrFail($check_router[0]->id);;
            		$new_connect->connect = 1;
            		$new_connect->save();
            	}
            	return response()->json([
            		'success' => true,
            		'message' => 'Router has been connect',
            		'data' => $new_connect
            	]);
            }else{
            	$my_mikrotik=new MikrotikRouter;
            	$my_mikrotik->identity = $identity[0]['name'];
            	$my_mikrotik->ip = $ip;
            	$my_mikrotik->user = $user;
            	$my_mikrotik->password = $password;
            	$my_mikrotik->connect = 1;
            	$my_mikrotik->save();
            	return response()->json([
            		'success' => true,
            		'message' => 'Fetch interface data',
            		'data' => $my_mikrotik
            	]);
            }
            
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Router not connect'
            ]);
        }
    }

    public function get_router_data(Request $request){
    	$connect = MikrotikRouter::where('connect', 1)->get();

    	if(count($connect) > 0){
    		$request_check = $request->request_check;

    		$API = new RouterosAPI();
    		$API->connect($connect[0]->ip, $connect[0]->user, $connect[0]->password  ? $connect[0]->password : '');
    		$result = $API->comm($request_check);

    		return response()->json([
    			'success' => true,
    			'message' => 'Fetch interface data',
    			'data' => $result
    		]);

    		$API->disconnect();
    	}else{
    		return response()->json([
                'success' => false,
                'message' => 'Router not connect'
            ]);
    	}
        
    }
}