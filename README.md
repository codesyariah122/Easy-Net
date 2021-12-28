### For Data Center Easy Net (isp) - Bandung
### Realtime Notification with  Websocket and Pusher  
#### Setup
```
# clone this repo
<!-- File Database Seeder -->
// edit this line
$this->call(Administratorseeder::class);
```
```
cd Easy-Net/
cd easynet-api/
cp .env.example .env //Setup .env for your local machine
composer install
composer require laravel/ui
php artisan ui vue
npm install && npm run dev

<!-- Install Passport -->
composer require laravel/passport
php artisan migrate --seed
php artisan passport:install
```  

#### Setup .env  
##### Mail Server Setup  
```
MAIL_MAILER=smtp
MAIL_HOST=mail.youremail.com
MAIL_PORT=587
MAIL_USERNAME=your_username@youremail.com
MAIL_PASSWORD=youremailpassword
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=your_username@youremail.com
MAIL_FROM_NAME="${APP_NAME}"
```  
##### Pusher & Broadcast Setup  
```
BROADCAST_DRIVER=pusher

// pusher account
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=
```  

#### Customer Factory  

```
composer dump-autoload
php artisan tinker
User::factory()->count(20)->create()
```  
#### Mikrotik RouterosAPI  
<img src="/ss/RoterosAPI7.jpg">
<img src="/ss/RoterosAPI8.jpg">
<img src="/ss/RoterosAP9.jpg">
<img src="/ss/RoterosAPI10.jpg">
<img src="/ss/RoterosAPI.jpg">
<img src="/ss/RoterosAPI1.jpg">  
<img src="/ss/RoterosAPI2.jpg">   

##### By Request  
<img src="/ss/RoterosAPI3.jpg">  
<img src="/ss/RoterosAPI4.jpg">
<img src="/ss/RoterosAPI5.jpg">
<img src="/ss/RoterosAPI6.jpg">

<img src="/ss/login-notif1.jpg">
<img src="/ss/login-notif2.jpg">
<img src="/ss/logout-notif1.jpg">
<img src="/ss/logout-notif2.jpg">
<img src="/ss/profile1.jpg">  
<img src="/ss/contact-message-a.jpg">
<img src="/ss/contact-message.jpg">  
<img src="/ss/contact-message1-a.jpg">
<img src="/ss/contact-message2.jpg">
<img src="/ss/contact-message2-a.jpg">
<img src="/ss/dashboard9.jpg">  
<img src="/ss/dashboard8.jpg">  
<img src="/ss/dashboard4.jpg">  
<img src="/ss/dashboard5.jpg">  
<img src="/ss/dashboard6.jpg">  
<img src="/ss/dashboard7.jpg">  
<img src="/ss/life-notif1.jpg">  
<img src="/ss/life-notif2.jpg">  

<img src="/ss/mail_admin.jpg"> 
<img src="/ss/activation_via_email.jpg">
<img src="/ss/activation_via_email2.jpg">
<img src="/ss/activation_via_email3.jpg">
<img src="/ss/activation_via_email4.jpg">
<img src="/ss/activation_via_email5.jpg">

<img src="/ss/ss1.jpg">  
<img src="/ss/ss3.jpg">  

halo semuanya  project terbaru ini merupakan sebuah project yang saya kerjakan untuk sebuah perusahaan jasa layanan internet, atau biasa kita sebut  ISP(Internet Service Provider). Repo  ini bagian dari project untuk sebuah aplikasi website untuk perusahaan  ISP ini.   
<img src="/ss/ss2.jpg">  

<img src="/ss/ss4.jpg">   
<img src="/ss/ss5.jpg">  
<img src="/ss/ss6.jpg"> 
<img src="/ss/ss7.jpg">

