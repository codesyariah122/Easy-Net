<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendContactEmail;
use App\Mail\ReplyContactMessageToEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\ApiKeys;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Package;
use App\Models\Order;
use App\Models\Chat;
use App\Models\Map;
use App\Models\MapCategory;
use App\Models\Contact;
use App\Models\ContactCategory;
use App\Models\LogLogin;
use App\Models\MikrotikRouter;
use App\Events\TestingEvent;
use App\Events\ContactMessageEvent;
use App\Models\Notification;
use App\Events\NotificationEvent;
use App\MyMethod\MyHelper;




class DataCenterController extends Controller
{

    public function test_helper()
    {
        $path = new MyHelper("test aja");
        echo $path->GetMyContext();
    }

    public function CategoryMessage($apiKey)
    {
        try{
            $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
            if($token[0]['token'] === $apiKey){
                $categories = ContactCategory::get();
                 return response()->json([
                    'message'=>"Fetch Category Message",
                    'data'=>$categories
                ]);
            }else{
                return response()->json([
                    'message' => 'Api token not registration'
                ]);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error fetch data if no token'
            ], 401);
        }
    }


    public function SendingMessage(Request $request, $apiKey)
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
                $admin = User::where('roles', json_encode(["ADMIN"]))
                        ->where('email', 'admin@easynet.id')
                        ->where('status', 'ACTIVE')
                        ->get();
                $roles = 'admin';
                // echo $roles; die;
            }elseif($category_contact[0]['category_contact_name'] === "tanya easynet sales"){
                $admin = User::where('roles', json_encode(["SALES"]))->where('status', 'ACTIVE')->get();
                $roles = 'sales';
                // echo $roles; die;
            }else{
                $admin = User::where('roles', json_encode(["SUPPORT"]))->where('status', 'ACTIVE')->get();
                $roles = 'support';
                // echo $roles; die;
            }
            // var_dump($admin[0]->email);die;
            $format_telp = new MyHelper;
            $new_message->phone=$format_telp->format_phone($request->phone);
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
            $new_notification->name = "contact";
            $new_notification->content = $event_context['message'];
            $new_notification->route = $event_context['route'];
            $new_notification->save();

            $data_event = broadcast(new NotificationEvent($event_context));

            
            // echo $new_message->phone; die;
            $details = [
              'title' => 'Pesan baru dari easynet website',
              'url' => 'https://easynet.id',
              'roles' => $roles,
              'route' => $admin[0]->username,
              'fullname' => $new_message->fullname,
              'email' => $new_message->email,
              'phone' => $new_message->phone,
              'message'=> $new_message->message
            ];
            try{
                // echo $admin[0]->email; die;
                Mail::to($admin[0]->email)->send(new SendContactEmail($details));
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

    // public function HeloEvent()
    // {
    //     try{
    //         $context="Broadcasting Events using web sockets";
    //         $data = broadcast(new NotificationWeb($context));
    //         return response()->json([
    //             'message'=>"New event broadcast !",
    //             'data'=>$context
    //         ]);
    //     }catch(Exception $e){
    //         return response()->json([
    //             'message' => 'Error fetch data if no token'
    //         ], 401);
    //     }

    // }

    // public  function ContactMessage($apiKey){
    //     $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
        
    //     try{
    //        if($token[0]['token'] === $apiKey){
    //             $new_contact=Contact::with('contact_categories')->latest()->get();
    //             // var_dump($new_contact);  die;
    //             $data = broadcast(new ContactMessageEvent(count($new_contact)." pesan baru dari ".$new_contact[0]['fullname']." terkirim ke admin easynet !"));
    //             return response()->json([
    //                 'message'=>count($new_contact)." pesan baru dari ".$new_contact[0]['fullname']."di kirim ke admin easynet !",
    //                 'data'=>$new_contact
    //             ]);
    //         }else{
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Api token not registration'
    //             ]);
    //         }
    //     }catch(Exception $e){
    //         return response()->json([
    //             'message' => 'Error fetch data if no token'
    //         ], 401);
    //     }
    // }

    // public function TestBroadcast($apiKey)
    // {
    //     $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
    //     try{
    //         if($token[0]['token'] === $apiKey){
    //             // $data = TestingEvent::dispatch('TestingEvent maang nya')
    //             $userlogin = User::latest()->where('login', 1)->get();
    //             // echo count($userlogin);die;
    //             $data = broadcast(new TestingEvent($userlogin[0]['username']." user sedang online !"));

    //             return response()->json([
    //                 'message'=>$userlogin[0]['username']." user sedang online !",
    //                 'data'=>$userlogin
    //             ]);
    //         }else{
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Api token not registration'
    //             ]);
    //         }
    //     }catch(Exception $e){
    //         return response()->json([
    //             'message' => 'Error fetch data if no token'
    //         ], 401);
    //     }
        
    // }

    public function IpLocator($ip,$apiKey)
    {
        $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
        
        try{
            if($token[0]['token'] === $apiKey){

                // $response = Http::get('https://api.ipify.org/?format=json');
                // $ip = $response->json();
                $fetchs = Http::get("https://ipapi.co/{$ip}/json");
                $location = $fetchs->json();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Fetch Location',
                    'data' => $location
                ], 201);

            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Api token not registration'
                ]);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error fetch data if no token'.$e->getMessage()
            ], 401);
        }
    }

    public function WebData($apiKey)
    {
        $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
        try{
            if($token[0]['token'] === $apiKey){
                $data = [
                    'title' => 'EasyNet :: Website',
                    'headerLogo' => '',
                    'headerText' => "Nikmati layanan <span class='text-warning'>High Performance Internet</span><span class='text-info text-justify'>Unlimited Bandwidth</span> Bersama <span class='text-info fw-bold'>Easy Net</span>",
                    'headerParagraph' => "Melalui infrastruktur High Speed internet kami. Kami siap memenuhi kebutuhan aktifitas anda mulai dari aktifitas Multimedia, Mailing, Study, Streaming hingga , Gaming",
                    'headerContent' => 'Menyambut era revolusioner internet dalam spektrum gelombang Meta Universe dan internet 5G. Dengan akses internet cepat tentunya kami siap menjadi partner terdepan anda dalam menyongsong meta universe dan internet 5G di era internet masa mendatang. Untuk anda kami akan hadirkan pengalaman menggunakan internet yang stabil dan ramah bagi lingkup bisnis, keluarga dan entertainment.',
                    'headerCaution' => 'Masih mendapati masalah seperti ini !! Buruan pasang EasyNet.',
                    'imageHero' => url('image/data-center.jpg'),
                    'videoHeader' => url('video/video2.mp4')
                ];

                return response()->json([
                    'message' => 'Fetch Data Website',
                    'data' => $data
                ], 201);

            }else{
                return response()->json([
                    'message' => 'Api token not registration'
                ]);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error fetch data if no token'.$e->getMessage()
            ], 401);
        }
    }

    public function PackageProduct($apiKey)
    {
        $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
        $products = Product::with('categories')
                    ->with('packages')
                    ->get();
        try{
            if($token[0]['token'] === $apiKey){
                return response()->json([
                    'success' => true,
                    'message' => 'Fetch product data',
                    'data' => $products
                ], 201);
            }else{
                return response()->json([
                    'message' => 'Api token not registration'
                ]);
            }
        }catch(Exception $e){
           return response()->json([
                'message' => 'Error fetch data product'.$e->getMessage()
            ], 401); 
        }
        
    }

    public function DetailPackage($slug, $apiKey)
    {
        // echo $slug; die;
        $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
        $packages = Product::with('categories')
                    ->with('packages')
                    ->where('slug', $slug)
                    ->first();
         try{
            if($token[0]['token'] === $apiKey){
                return response()->json([
                    'success' => true,
                    'message' => 'Fetch product data',
                    'data' => $packages
                ], 201);
            }else{
                return response()->json([
                    'message' => 'Api token not registration'
                ]);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error fetch data product'.$e->getMessage()
            ], 401); 
        }
    }

    public function CheckEmailUser(Request $request, $apiKey)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email'
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            }

            $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
            if($token[0]['token'] === $apiKey){
                $email = $request->email;
                $user = User::where('email', $email)
                        ->first();
                // var_dump($user->id); die;
                
                if($user == NULL){
                    return response()->json([
                        'not_register' => true,
                        'message' => 'Kamu belum terdaftar di system kami, silahkan  create new account'
                    ]); 
                }
                $chat = Chat::with('users')
                        ->where('user_id', $user->id)
                        // ->where('roles', '=', json_encode(['MEMBER']))
                        ->get();

                // $roles=json_decode($chat[0]['users'][0]['roles']);

                if(count($chat) % 2 == 1) {
                    return response()->json([
                        'message' => "Ok {$user->username}, username sudah aktif untuk menggunakan layanan chat",
                        'data' => $chat
                    ]);
                }else{
                   $new_chat = new Chat;
                   $new_chat->user_id = $user->id;
                   $new_chat->chat_aktif = $request->chat_aktif;
                   $new_chat->save();
                   $new_chat->users()->sync($new_chat->user_id);
                   $data = [
                        'id' => $user->id,
                        'username' => $user->username,
                        'fullname' => $user->name,
                        'email' => $user->email
                    ];
                    return response()->json([
                        'success' => true,
                        'message' => "Ok {$data['username']}, silahkan memulai chatt support di aplikasi live chatt easynet.id",
                        'data' => $data
                    ]); 
                }
                if($chat->user_id){
                    $data = [
                        'id' => $user->id,
                        'username' => $user->username,
                        'fullname' => $user->name,
                        'email' => $user->email
                    ];

                    $new_chat = new Chat;
                    $new_chat->user_id = $data['id'];
                    $new_chat->chat_aktif = $request->chat_aktif;
                    $new_chat->save();
                    $new_chat->users()->sync($new_chat->user_id);
                    return response()->json([
                        'success' => true,
                        'message' => "Ok {$data['username']}, silahkan memulai chatt support di aplikasi live chatt easynet.id",
                        'data' => $data
                    ]); 
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'User not found / email belum terdaftar'
                    ]); 
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Token failed'
                ]); 
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error fetch data if no token'.$e->getMessage()
            ], 401);
        }
    }

    public function ActiveChat($apiKey,$id)
    {
        $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
        if($token[0]['token'] === $apiKey){
            $chat_user =  User::with('chats')
                          ->findOrFail($id);
            // echo count($chat_user['chats']);
            // var_dump($chat_user['chats']);die;
            if(count($chat_user['chats']) > 0){                
                return response()->json([
                    'success' => true,
                    'message' => "Ok $chat_user->name, silahkan memulai chatt support di aplikasi live chatt easynet.id",
                    'data' => $chat_user
                ]);  
            }else{
                return response()->json([
                    'success' => false,
                    'message' => "{$chat_user->name} layanan chat belum di aktifkan"
                ]);
            }
        }else{
            return response()->json([
                'message' => 'Error fetch data if no token'.$e->getMessage()
            ], 401);
        }
    }

    public function Coordinate(Request $request, $apiKey)
    {
        $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
        if($token[0]['token'] === $apiKey){
            $coordinates = MapCategory::with('maps')
                            ->whereIn('map_categories.id', [1,2])
                            ->get();

            try{
                return response()->json([
                    'success' => true,
                    'message' => "Fetch coordinates data",
                    'data' => $coordinates
                ]);
            }catch(Exception $e){
                return response()->json([
                    'success' => false,
                    'message' => "Failed fetch coordinate data ".$e->getMessage()
                ]);
            }

        }else{
            return response()->json([
                'message' => 'Error fetch data if no token'
            ], 401);
        }
    }

    public function CoveregeArea(Request $request, $apiKey)
    {
        $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
        if($token[0]['token'] === $apiKey){
            $covereges = MapCategory::with('maps')
                         ->where('map_categories.id', '=', 3)
                         ->get();
            try{
                return response()->json([
                    'success' => true,
                    'message' => "Fetch covereges data",
                    'data' => $covereges
                ]);
            }catch(Exception $e){
                return response()->json([
                    'success' => false,
                    'message' => "Failed fetch covereges data ".$e->getMessage()
                ]);
            }

        }else{
            return response()->json([
                'message' => 'Error fetch data if no token'
            ], 401);
        }
    }

    public function CheckBeforeActivated($id)
    {
       $user =  User::with('order_users')->findOrFail($id);
       $order = Order::with('products')
                ->with('packages')
                ->findOrFail($user->order_users[0]->id);
       if($user->status === "INACTIVE"):
            try{
                return response()->json([
                    'success' => true,
                    'message' => "Halo ! {$user->name} lanjutkan aktivasi akunmu",
                    'target' => "Layanan internet dengan infrastruktur yang paling mutakhir dari EasyNet, sehingga jaringan internet yang menggunakan layanan EasyNet high perfomance akan merasakan pengalaman baru dalam menggunakan layanan fiber maupun broadband wireless dengan infrastruktur teknologi paling terkini. So tidak ada lagi koneksi yang lag ataupun ghosting, ngebuttt terrusss bersama EasyNet.",
                    'data' => $user,
                    'order' => $order
                ]); 
            }catch(Exception $e){
                return response()->json([
                    'success' => false,
                    'message' => "Activation Failed ".$e->getMessage()
                ]);
            }
        else:
            return response()->json([
                'ready' => true,
                'data' => $user
            ]);
        endif;
    }

    public function UserActivation(Request $request, $id)
    {
        $user =  User::findOrFail($id);
        if($user->status === "INACTIVE"):
            $user->status = $request->status;
            $user->save();
            try{
               return response()->json([
                        'success' => true,
                        'message' => "Halo ! {$user->name} akunmu sudah teraktivasi",
                        'data' => $user
                    ]); 
            }catch(Exception $e){
                return response()->json([
                    'success' => false,
                    'message' => "Activation Failed ".$e->getMessage()
                ]);
            }
        else:
            return response()->json([
                'ready' => true
            ]);
        endif;
    }


    public function CountUserLogin($apiKey)
    {
        $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
        if($token[0]['token'] === $apiKey){
            $user_login =  User::with('log_logins')
            ->where('login', 1)->get();
            try{
                if(count($user_login) > 0){
                    return response()->json([
                        'success' => true,
                        'message' => count($user_login)." user online",
                        'data' => $user_login
                    ]); 
                }else{
                    return response()->json([
                        'success' => true,
                        'message' => count()." user online",
                        'data' => $user_login
                    ]);     
                }
             }catch(Exception $e){
                return response()->json([
                    'success' => false,
                    'message' => "Log Failed ".$e->getMessage()
                ]);
            }
        }else{
            return response()->json([
                'message' => 'Error fetch data if no token'
            ], 401);
        }
    }

    public function WeatherCity($city,$apiKey)
    {
        $api_weather=env('WEATHER_API');
        $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
        try{
            if($token[0]['token'] === $apiKey){

                // $response = Http::get('https://api.ipify.org/?format=json');
                // $ip = $response->json();
                $fetchs = Http::get("https://api.openweathermap.org/data/2.5/weather?q={$city}&units=imperial&appid={$api_weather}");
                $weather = $fetchs->json();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Fetch Weather',
                    'data' => $weather
                ], 201);

            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Error Fetch Weather'
                ]);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error fetch data if no token'.$e->getMessage()
            ], 401);
        }
    }

    public function CheckActiveUser($email, $apiKey)
    {
        $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
        try{
            if($token[0]['token'] === $apiKey){
                $check_user = User::whereEmail($email)->pluck('status');
                return response()->json([
                    'success' => true,
                    'message' => 'Fetch Check User',
                    'data' => $check_user
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Error Fetch Check User'
                ]);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error fetch data '.$e->getMessage()
            ], 401);
        }

    }

}
