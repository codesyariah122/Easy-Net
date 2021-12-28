<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Profile;
use App\Models\LogLogin;
use Auth;
use App\MyMethod\MyHelper;

class UserManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function($request, $next){

        if(Gate::allows('user-manage')) return $next($request);
            abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }

   

    public function index(Request $request)
    {
        $users = User::latest()
                ->where("email", "!=", Auth::user()->email)
                ->paginate(8);
        try{
            return response()->json([
                'success' => true,
                'message' => 'Fetch user data',
                'data' => $users
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('profiles')
                ->with('product_users')
                ->with('package_users')
                ->with('log_logins')
                ->findOrFail($id);
        try{
            return response()->json([
                'success' => true,
                'message' => 'Fetch user detail',
                'data' => $user
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('profiles')
                ->with('product_users')
                ->with('package_users')
                ->findOrFail($id);
        try{
            return response()->json([
                'success' => true,
                'message' => 'Fetch user detail',
                'data' => $user
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'roles' => 'required',
            // 'photo' => 'mimes:jpg,bmp,png|max:5024',/
            'status' => 'required',
            'city' => 'required',
            'province' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        try{
           $phone_format = new MyHelper;

           $user_update = User::findOrFail($id);
           $user_update->name = $request->name;
           $user_update->email = $request->email;
           $user_update->username = trim(preg_replace('/\s+/', '_', $user->name));
           $user_update->phone = $phone_format->format_phone($request->phone);
           $user_update->gender = $request->gender;
           $user_update->status = $request->status;
           $user_update->city = $request->city;
           $user_update->province = $request->province;
           $user_update->save(); 

            return response()->json([
                'success' => true,
                'message' => 'User update successfull !!!',
                'data' => $user_update
            ]);
       }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
       }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::with('profiles')
                ->with('product_users')
                ->with('package_users')
                ->findOrFail($id);
        // var_dump($user); die;
        try{
            $user->delete();
             return response()->json([
                'success' => true,
                'message' => $user->name.' delete successfull !!!',
                'data' => $user
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
       }
        
    }
}
