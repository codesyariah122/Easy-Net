<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\SendEmailNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Profile;
use App\Models\ProductUser;
use App\Models\PackageUser;
use App\Models\Notification;
use App\Events\NotificationEvent;

class RegisterController extends Controller
{
    //
    public function format_phone($nohp) {
         // kadang ada penulisan no hp 0811 239 345
       $nohp = str_replace(" ","",$nohp);
         // kadang ada penulisan no hp (0274) 778787
       $nohp = str_replace("(","",$nohp);
         // kadang ada penulisan no hp (0274) 778787
       $nohp = str_replace(")","",$nohp);
         // kadang ada penulisan no hp 0811.239.345
       $nohp = str_replace(".","",$nohp);
       // kadang ada penulisan no hp 0811-239-345
       $nohp = str_replace("-","",$nohp);
         // cek apakah no hp mengandung karakter + dan 0-9
       if(!preg_match('/[^+0-9]/',trim($nohp))){
             // cek apakah no hp karakter 1-3 adalah +62
           if(substr(trim($nohp), 0, 3)=='+62'){
               $hp = trim($nohp);
           }
             // cek apakah no hp karakter 1 adalah 0
           elseif(substr(trim($nohp), 0, 1)=='0'){
               $hp = '62'.substr(trim($nohp), 1);
           }
       }
       return $hp;
   }
    public function register(Request $request)
    {
        // echo "Test"; die;
        // var_dump($request->all()); die;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:10|confirmed',
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

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $this->format_phone($request->phone);
        $user->roles = json_encode($request->roles);
        $user->status = $request->status;
        if($request->file('photo')){
            $file = $request->file('photo')->store(trim(preg_replace('/\s+/', '', $user->name)).'/image/profile', 'public');
          $user->photo = $file;
        }
        $manipulation_email = strpos($user->email, '@');
        $email_domain = substr($user->email, $manipulation_email + 1);
        // echo $email_domain; die;
        $user->password = Hash::make($request->password);
        $user->city = $request->city;
        $user->province = $request->province;
        $user->login = $request->login;
        $user->username = trim(preg_replace('/\s+/', '_', $user->name));
        $user->save();

        $profile = new Profile;
        $profile->address = $request->address;
        $profile->post_code = $request->post_code;
        $profile->save();
        $profile_id = $profile->id;


        $user->profiles()->sync($profile_id);
        
        // Product user table sync

        $product_user = new ProductUser;
        $product_user->user_product_name = 'prouct - '.$user->username;
        $product_user->user_id = $user->id;
        $product_user->product_id = $request->product_id;
        $product_user->save();
        $product_user_id = $product_user->id;
        $user->product_users()->sync($product_user_id);

        $package_user = new PackageUser;
        $package_user->user_package_name = 'package - '.$user->username;
        $package_user->user_id = $user->id;
        $package_user->package_id = $request->package_id;
        $package_user->save();
        $package_user_id = $package_user->id;
        $user->package_users()->sync($package_user_id);

        $details = [
          'title' => 'Kamu Telah Berhasil Registrasi Di Website easynet.id',
          'url' => 'https://easynet.id',
          'id' => $user->id,
          'username' => $user->username,
          'email' => $user->email,
          'phone' => $user->phone
        ];
        try{
          $event_context = [
            "notif"  => true,
            "message" => $user->name." berhasil registrai",
            "route" => "/users"
          ];

          $new_notification = new Notification;
          $new_notification->name = $user->name. "  telah registrasi";
          $new_notification->content = $event_context['message'];
          $new_notification->route = $event_context['route'];
          $new_notification->save();

          $data_event = broadcast(new NotificationEvent($event_context));

          Mail::to($user->email)->send(new SendEmailNotification($details));
            return response()->json([
                'success' => true,
                'message' => "Halo ! {$user->name}, registrasi kamu berhasil, silahkan check inbox <a href='https://{$email_domain}' target='_blank' class='btn btn-link'>{$user->email}</a> untuk mengaktifkan akun kamu.",
                'data' => $user
            ], 202);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Register failed',
                'data' => $e->getMessage()
            ], 401);
        }
    }
}
