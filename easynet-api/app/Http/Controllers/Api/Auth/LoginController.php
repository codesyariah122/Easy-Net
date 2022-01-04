<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Profile;
use App\Models\LogLogin;
use App\Models\Notification;
use Auth;
use App\Events\NotificationEvent;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            }
            $user = User::where('email', $request->email)->first();

            if(!$user){
                return response()->json([
                    'error_login' => true,
                    'err_message' => 'Data user tidak ditemukan / belum terdaftar'
                ]);
            }else{
                if($user->login % 2  == 1){
                    return response()->json([
                        'userhaslogin' => true,
                        'message' => 'Akun anda sedang digunakan.'
                    ]);
                }
                if($user->status == "INACTIVE"):
                    return response()->json([
                        'activated' => true,
                        'message' => 'Silahkan check email anda! '.$user->email.' di bagian inbox  kemudian aktivasi akun anda dari link activation yang telah kami kirimkan.'
                    ]);
                else:
                    if(!Hash::check($request->password, $user->password)){
                        return response()->json([
                            'success' => false,
                            'message' => 'Wrong Email Or Password'
                        ]);
                    }
    
                    $login = User::findOrFail($user->id);
                    $login->login = 1;
                    $login->save();

                    // log logins
                    $check_log = LogLogin::where('name', $user->username)->get();
                    // echo count($check_log);
                    // var_dump($check_log);
                    // die;
                    if(count($check_log) % 2 == 1){
                        $log_login = LogLogin::findOrFail($check_log[0]->id);
                        $log_login->login = 1;
                        $log_login->save();
                    }else{
                        $log_login = new LogLogin;
                        $log_login->name = $login->username;
                        $log_login->ip = $request->ip;
                        $log_login->city = $request->city;
                        $log_login->province = $request->province;
                        $log_login->login = 1;
                        $log_login->save();
                    }

                    $login->log_logins()->sync($log_login->id);


                    $event_context = [
                        "notif"  => true,
                        "message" => $user->name." sedang login",
                        "name" => "login",
                        "route" => "/logs"
                    ];

                    // var_dump($user->roles); die;

                    if(!in_array("ADMIN", json_decode($user->roles)) && !in_array("SALES", json_decode($user->roles)) && !in_array("SUPPORT", json_decode($user->roles))){
                        $new_notification = new Notification;
                        $new_notification->name = "login";
                        $new_notification->content = $event_context['message'];
                        $new_notification->route = $event_context['route'];
                        $new_notification->save();

                        $data_event = broadcast(new NotificationEvent($event_context));
                    }

                    return response()->json([
                        'success' => true,
                        'message' => 'Login Success!',
                        'data' => $login,
                        'token' => $user->createToken('authToken')->accessToken
                    ]);
                endif;
            }
        }catch(Exception $e){
            return response()->json([
                'error-network' => true,
                'message' => 'Error server'
            ]);
        }
    }

    public function logout(Request $request)
    {
        $id =  $request->id;
        $log_id = $request->log_id;
        $user = User::findOrFail($id);
        $user->login = 0;
        $user->save();

        // $log_login = LogLogin::findOrFail($log_id);
        // $log_login->login = 0;
        // $log_login->save();
        // var_dump($request->token);  die;
        // var_dump($request->user()); die;
            // log logins
        $check_log = LogLogin::findOrFail($log_id);
                        // var_dump($check_log);
                        // echo count($check_log); die;
        if($check_log){
           $log_login = LogLogin::findOrFail($check_log->id);
           $log_login->login = 0;
           $log_login->save();
         }else{
            $log_login = new LogLogin;
            $log_login->login = 0;
            $log_login->save();
        }

        $user->log_logins()->sync($log_login->id);

        $removeToken = $request->user()->tokens()->delete();


        if($removeToken){
            $event_context = [
                "notif"  => true,
                "message" => $user->name." telah logout",
                "name" => "logout",
                "route" => "/logs"
            ];
            if(!in_array("ADMIN", json_decode($user->roles)) && !in_array("SALES", json_decode($user->roles)) && !in_array("SUPPORT", json_decode($user->roles))){
                $new_notification = new Notification;
                $new_notification->name = "logout";
                $new_notification->content = $event_context['message'];
                $new_notification->route = $event_context['route'];
                $new_notification->save();

                $data_event = broadcast(new NotificationEvent($event_context));
            }
            return response()->json([
                'success' => true,
                'message' => 'Logout Success!',
                'data' => $log_id
            ]);
        }
    }

    public function UserProfile(Request $request)
    {
        $user= $request->user();
        $userprofile = User::with('profiles')
                        ->with('product_users')
                        ->with('package_users')
                        ->with('log_logins')
                        // ->join('profile_user','users.id', '=',  'profile_user.user_id')
                        ->where('email', $user->email)
                        ->get();
        try{
            return response()->json([
                'success' => true,
                'message' => 'Fetch user data',
                'data' => $userprofile
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
