<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\ApiKeys;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Package;
use App\Models\Chat;
use App\Models\Map;
use App\Models\MapCategory;
use App\Models\Contact;
use App\Models\ContactCategory;
use App\Models\LogLogin;
use App\Events\TestingEvent;
use App\Events\ContactMessageEvent;
use App\Events\NotificationWeb;



class DataCenterController extends Controller
{

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

    public function HeloEvent()
    {
        try{
            $context="Broadcasting Events using web sockets";
            $data = broadcast(new NotificationWeb($context));
            return response()->json([
                'message'=>"New event broadcast !",
                'data'=>$context
            ]);
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error fetch data if no token'
            ], 401);
        }

    }

    public  function ContactMessage($apiKey){
        $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
        
        try{
           if($token[0]['token'] === $apiKey){
                $new_contact=Contact::with('contact_categories')->latest()->get();
                // var_dump($new_contact);  die;
                $data = broadcast(new ContactMessageEvent(count($new_contact)." pesan baru dari ".$new_contact[0]['fullname']." terkirim ke admin easynet !"));
                return response()->json([
                    'message'=>count($new_contact)." pesan baru dari ".$new_contact[0]['fullname']."di kirim ke admin easynet !",
                    'data'=>$new_contact
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Api token not registration'
                ]);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error fetch data if no token'
            ], 401);
        }
    }

    public function TestBroadcast($apiKey)
    {
        $token = ApiKeys::join('users', 'api_keys.user_id', '=', 'users.id')->get();
        try{
            if($token[0]['token'] === $apiKey){
                // $data = TestingEvent::dispatch('TestingEvent maang nya')
                $userlogin = User::latest()->where('login', 1)->get();
                // echo count($userlogin);die;
                $data = broadcast(new TestingEvent($userlogin[0]['username']." user sedang online !"));

                return response()->json([
                    'message'=>$userlogin[0]['username']." user sedang online !",
                    'data'=>$userlogin
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Api token not registration'
                ]);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error fetch data if no token'
            ], 401);
        }
        
    }

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
                    'headerText' => "Nikmati layanan <span class='text-warning'>High Speed Internet</span><span class='text-info text-justify'>Unlimited Bandwidth</span> Bersama <span class='text-info fw-bold'>Easy Net</span>",
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
       $user =  User::findOrFail($id);
       if($user->status === "INACTIVE"):
            try{
                return response()->json([
                    'success' => true,
                    'message' => "Halo ! {$user->name} lanjutkan aktivasi akunmu",
                    'target' => "Layanan internet dengan infrastruktur yang paling mutakhir dari EasyNet, sehingga jaringan internet yang menggunakan layanan EasyNet high perfomance akan merasakan pengalaman baru dalam menggunakan layanan fiber maupun broadband wireless dengan infrastruktur teknologi paling terkini. So tidak ada lagi koneksi yang lag ataupun ghosting, ngebuttt terrusss bersama EasyNet.",
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

}
