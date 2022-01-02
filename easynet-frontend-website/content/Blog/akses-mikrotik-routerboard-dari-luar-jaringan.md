---
title: Akses Mikrotik Routerboard Dari Luar Jaringan / Public
description: Ingin mikrotik anda bisa diremote jarak jauh dari luar jaringan lewat internet menggunan HP, laptop atau komputer?...
slug: akses-mikrotik-routerboard-dari-luar-jaringan
img: ipcloud-mikrotik1.jpg
author:
  name: puji ermanto
  bio: Script Again Coffee Again
  jobdesk: Fullstack Web Developer
  img: 'https://avatars.githubusercontent.com/u/13291805?v=4'
  cover: '/assets/images/logo/logo-blue.svg'

categories: blog
createdAt: DateTime
updatedAt: DateTime
tags:
  - EasyNet Tips  
---

#### Cara Remote Mikrotik Online Dengan IP Public  
Jika anda mendapat IP public dari ISP, maka anda bisa langsung meremote mikrotik dari jarak jauh (luar jaringan) menggunakan internet.

IP public yang nempel di interface WAN bisa anda ketikan langsung di aplikasi remote SSH, Winbox ataupun mikhmon, maka anda akan bisa diakses langsung lewat internet. 


##### Bagaimana cara mengetahui IP dari ISP adalah public?  
Untuk mengetahui jenis IP yang diberikan oleh ISP ke anda, caranya mudah,

cek saja di menu ```IP > Address > lihat IP``` yang nempel di interface WAN (interface yang mengarah ke ISP).  
Jika IP nya tidak diawali dengan 192.168. atau 10. dan 172.16. maka anda mendapat IP Public dari ISP.  

<img src="https://www.tembolok.id/wp-content/uploads/2021/10/ip-public-isp.jpg.webp" class="img-fluid">  

##### Mengatasi IP Public dari ISP selalu Berubah (IP Public Dynamic)  
Beberapa ISP sengaja memberi alokasi IP dynamic ke pelanggan nya dengan tujuan agar pelanggan nya aman (tidak bisa ditarget oleh hacker).

Tapi ini akan menjadi masalah jika anda perlu mengakses mikrotik dari luar jaringan lewat internet.

Ketika modem, mikrotik reboot atau koneksi terputus IP public pasti akan berubah/ganti.  

Untuk mengatasi problem ini, anda bisa memanfaatkan fitur IPcloud/DDNS di mikrotik.

    1. Masuk ke menu IP > Cloud
    2. centang DDNS enable > update interval isi 00:02:00
    3. Klik Apply > OK  

<img src="https://www.tembolok.id/wp-content/uploads/2021/10/ip-cloud-mikrotik-1000x204.jpg.webp" class="img-fluid">  

Anda sekarang tidak perlu kuatir kalau IP public berubah-ubah.

Karena mulai dari sekarang yang anda harus catet adalah DNS Name yang ada di fitur IP cloud mikrotik.

alamatnya biasanya : randomcharacter.sn.mynetname.net

Dimana randomcharacter merupakan identitas uniq dari setiap router mikrotik di dunia in yang hanya ada satu.

Untuk keperluan remote, mulai sekarang yang anda ketikan di address bar atau host bukan lagi IP, tapi subdomain atau DNS name yang tertera di mikrotik anda.  

<img src="https://www.tembolok.id/wp-content/uploads/2021/10/remote-mikrotik-ipcloud-ddns.jpg.webp" class="img-fluid">  

##### Cara Remote Mikrotik Online Tanpa Ip Public  
Tapi bagaimana jika anda tidak mendapat IP public dari ISP tapi ingin mengakses mikrotik dai jarak jauh via online?

Jangan kuatir, karena anda tetap bisa mengakses mikrotik anda dari jarak jauh secara online via internet tanpa perlu IP public.  

###### Tunneling  
Hanya ada satu cara agar mikrotik anda bisa diremote jarak jauh walau tidak punya IP public.

Anda harus memasang IP tunnel, atau VPN tunnel yang menyediakan port forwarding.  
Nantinya anda bisa mengakses mikrotik anda dengan IP server VPN anda dengan port tertentu.

Biasanya layanan ini berbayar.

Caranya anda hanya perlu langanan layanan VPN tunnel premium agar mikrotik anda bisa diakses dari jarak jauh.  

##### Resiko & Bahaya Memakai Remote Akses Jarak Jauh  
Memang sekarang mikrotik anda bisa diakses darimanapun dengan sangat mudah.

Tapi orang lain juga bisa mengakses mikrotik anda dengan mudah pula, termasuk hacker.

Hacker tidak perlu tau IP dan port mikrotik anda, bahkan username dan password nya.

Karena hacker sudah membuat aplikasi robot otomatis yang jalan 24jam guna mencari IP dan port mikrotik yang ada di internet dan mencoba kombinasi username dan password.

Jika username dan password anda sangat mudah ditebak, bahaya besar mengincar router mikrotik anda.

Lalu bagaimana cara mengamankan mikrotik anda dari serangan hacker setelah mengaktifkan fitur remote akses jarak jauh?  

##### Buat kombinasi akun login yang kuat  
admin adalah username default mikrotik, hindari menggunakan username yang umum dipakai.

Buatlah username yang uniq serta password minimal 8 karakter campuran antara huruf besar, kecil dan angka.

Tujuan nya agar mikrotik anda tidak mudah ditembus oleh serangan brute force.

**Brute force** adalah serangan dengan cara menebak kombinasi username dan password yang dilakukan oleh BOT.  

##### Terapkan Firewall di router anda  
Begitu anda mengaktifkan fitur remote mikrotik jarak jauh, port(pintu masuk) router anda akan bisa digedor oleh siapapun yang terkonek ke internet.

Tapi jangan kuatir, hanya yang punya kunci (username password) yang bisa masuk.

Tetapi hacker selalu ingin mencongkel pintu untuk memaksa masuk (brute force).

Untuk membatasi percobaan hacker yang ingin “nyongkel/dobrak” pintu anda bisa memasang firewall di router anda. 
Misal anda membatasi berapa kali percobaan login yang boleh dilakukan oleh suatu host.

Misal jika salah 3x berturut-turut kurang dari semenit maka IP pelaku akan diblock dalam tempo tertentu.  


##### Selalu perbaharui versi package OS mikrotik anda  
Tidak semua serangan fokus di bruteforce (mencoba kombinasi kunci), ada beberapa serangan memanfaatkan celah/bug yang ada di sistem operasi mikrotik.

Ibaratnya jika ini sebuah pintu, mungkin engsel atau lem/las kurang kuat yang bisa disongkel hacker untuk masuk ke sistem.

Dengan melakukan update secara berkala dan memakai versi terbaru, anda akan terhindar dari serangan exploit.  

##### Gunakan layanan remote mikrotik Tembolok.ID  
Tembolok.ID menyediakan layanan akses mikrotik jarak jauh dengan lebih aman dan nyaman.

**Aman** , karena server transit sudah dipasang filter/firewall sehingga router mikrotik anda aman dari serangan bruteforce*

**Nyaman**, mendapat subdomain dengan nama sendiri sehingga mudah diingat.

Misal : namaMu.tembolok.id