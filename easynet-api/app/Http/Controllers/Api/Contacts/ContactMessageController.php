<?php

namespace App\Http\Controllers\Api\Contacts;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendContactEmail;
use App\Mail\ReplyContactMessageToEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Contact;
use App\Models\ContactCategory;
use App\Models\ApiKeys;
use App\Models\User;
use App\Models\Notification;
use App\Events\NotificationEvent;

class ContactMessageController extends Controller
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

        if(Gate::allows('contact-message')) return $next($request);
            abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }
    
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
           if(substr(trim($nohp), 0, 1)=='+'){
               $hp = ''.substr(trim($nohp),1);
           }elseif(substr(trim($nohp), 0, 2)=='62'){
               $hp = trim($nohp);
           }elseif(substr(trim($nohp), 0, 1)=='0'){
               $hp = '62'.substr(trim($nohp), 1);
           }
       }
       return $hp;
   }

    public function index()
    {
        //
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
    public function store(Request $request, $apiKey)
    {
        $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
        
        // echo count($admin);
        // echo "<br/>";
        // echo $admin[1]->username;
        // var_dump($admin); die;

        if($token[0]['token'] === $apiKey){
            $validator = Validator::make($request->all(), [
                'fullname' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'message' => 'required' 
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            }

            $new_message = new Contact;
            $new_message->fullname=$request->fullname;
            $new_message->email=$request->email;
            $contact_categories = $request->contact_categories;
            $category_contact = ContactCategory::where('id', $contact_categories[0])->get();
            // echo $category_contact[0]['category_contact_name'];
            if($category_contact[0]['category_contact_name'] === "pertanyaan umum" || $category_contact[0]['category_contact_name'] === "tanya easynet admin"){
                $admin = User::where('roles', json_encode(["ADMIN"]))->where('status', 'ACTIVE')->get();
                $roles = 'admin';
            }elseif($category_contact[0]['category_contact_name'] === "tanya easynet sales"){
                $admin = User::where('roles', json_encode(["SALES"]))->where('status', 'ACTIVE')->get();
                $roles = 'sales';
            }else{
                $admin = User::where('roles', json_encode(["SUPPORT"]))->where('status', 'ACTIVE')->get();
                $roles = 'support';
            }
            // var_dump($admin[0]->email);die;
            $new_message->phone=$this->format_phone($request->phone);
            $new_message->message=$request->message;
            $new_message->address=$request->address;
            $new_message->ip=$request->ip;
            $new_message->city=$request->city;
            $new_message->province=$request->province;
            $new_message->save();
            $new_message->contact_categories()->sync($request->contact_categories);

            $event_context = [
                "notif"  => true,
                "message" => "Pesan baru dari ".$new_message->fullname." terkirim ke ".$roles." easynet !",
                "name" => "contacts",
                "route" => "/contact"
            ];

            $new_notification = new Notification;
            $new_notification->name = "message from ".$roles." EasyNet";
            $new_notification->content = $event_context['message'];
            $new_notification->route = $event_context['route'];
            $new_notification->save();

            $data_event = broadcast(new NotificationEvent($event_context));

            
            // echo $new_message->phone; die;
            $details = [
              'title' => 'Pesan baru dari easynet website',
              'url' => 'https://easynet.id',
              'roles' => $roles,
              'route' => $admin[1]->username,
              'fullname' => $new_message->fullname,
              'email' => $new_message->email,
              'phone' => $new_message->phone,
              'message'=> $new_message->message
            ];
            try{
                Mail::to($admin[1]->email)->send(new SendContactEmail($details));
                Mail::to($new_message->email)->send(new ReplyContactMessageToEmail($details));
                return response()->json([
                    'success' => true,
                    'message' => $new_message->fullname.' baru saja mengirim pesan',
                    'data' => $new_message
                ], 202);
            }catch(Exception $e){
                return response()->json([
                    'success' => false,
                    'message' => 'New Map failed Added',
                    'data' => $e->getMessage()
                ], 401);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Api token not registration'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
