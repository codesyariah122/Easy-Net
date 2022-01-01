---
title: Cara Mengamankan Mikrotik Dari Hacker
description: Kita perlu mengamankan mikrotik agar tidak bisa dihack ketika terhubung ke jaringan internet. Hacker punya banyak cara untuk ngeHack mikrotik anda, mikrotik akan disandera dengan cara diubah password dan diaktifkan protected bootloader agar tidak bisa direset lalu meminta uang tebusan...
slug: cara-mengamankan-mikrotik-dari-hacker
img: mk2.jpg
author:
  name: puji ermanto
  bio: Script Again Coffee Again
  jobdesk: Fullstack Web Developer
  img: 'https://avatars.githubusercontent.com/u/13291805?v=4'
  cover: '/assets/images/logo/logo-blue.svg'

categories: blog
createdAt: DateTime
updatedAt: DateTime
---  

Anda perlu tau penyebab dan cara hacker masuk/ngehack mikrotik anda lalu melakukan pencegahan agar mikrotik tidak bia dihack.

Jika mikrotik anda sudah dihack dan tidak bisa direset karena protected bootloader maka ini adalah cara mengatasinya.  

##### Penyebab Mikrotik Bisa diHack  
Tidak semua mikrotik bisa dihack, ada kondisi tertentu yang bisa menyebabkan mikrotik dihack.

Kondisi tersebut bisa berasal dari kesalahan anda, tukang setting ataupun engineer mikrotik itu sendiri.  

##### Akun Mudah Ditebak  
Hal yang paling umum adalah mikrotik masih menggunakan akun default username: admin tanpa password.

Atau menggukan kombinasi username dan password yang mudah ditebak seperti user admin password 123456 atau qwerty dan sejenisnya.

Hal ini akan memperbesar peluang hacker berhasil melakukan serangan “brute force” ke mikrotik anda.  

Bruteforce adalah serangan dengan cara mencoba kombinasi username dan password yang umum digunakan.

Serangan ini menggunakan BOT yang kecepatan percobaan login nya bisa diatur, misal 5 percobaan login per detik.  

##### Mengguanakan layanan akses mikrotik online  
Menggunakan layanan tunnel agar mikrotik anda bisa diakses kapanpun dan dimananapun dari internet merupakan sebuah kemudahan.

Tapi perlu diingat, hacker juga akan mudah mengakses mikrotik anda.

Hacker bisa menemukan port walau sudah anda ubah dengan sangat mudah.

Karena layanan akses mikrotik online akan mengexpose port mikrotik anda ke internet.

Sekarang semua yang ada di internet bisa melihat dan masuk ke mikrotik menggunakan port tersebut.  

##### Router Tidak Pernah Diupdate  
Mungkin anda sudah mengganti password dengan kombinasi yang sulit ditebak dan panjang.

Tapi hacker punya cara lain selain bruteforce (mencoba login otomatis dengan bot) yaitu menggunakan exploit.  
Exploit ini bekerja dengan cara mengeploitasi ```bug/celah/vulnerability/```kelemahan yang ada pada sistem operasi router.

Tanpa perlu tau username dan password, hacker bisa langsung masuk ke mikrotik anda yang punya kelemahan/bug.

Biasanya bug ini ada pada versi mikrotik jadul yang tidak pernah diupdate.  

##### Akun Mikrotik Bocor  
Hacker sangat kreatif, jika tidak bisa njebol pertahanan router mikrotik dengan cara remote maka masih ada cara lain.

Cara nya adalah mendapatkan akses ke mikrotik dengan cara tipu tipu agar anda menyerahkan akun mikrotik.

Kedok yang dipakai biasanya adalah :  
- menawarkan bantuan setting gratis
- jasa setting murahan
- menawarkan bantuan cek settingan
- dan sejenisnya.  


##### Menggunakan Jasa Setting abal-abal  
Sedikit cerita,

Saya menerima jasa setting untuk mengatasi berbagai masam masalah di jaringan mulai dari kantor, sekolah, instansi pemerintahan dan RT RW Net.

Tapi ada satu hal yang menarik yaitu beberapa client saya tidak punya akses full ke mikrotiknya.

Setelah saya tanya ternyata saya bukan orang pertama yang mensetting mikrotik tersebut.

Mau tidak mau router harus direset agar bisa mendapat akses full ( yang nyeting sebelum nya tidka bisa dikontak)

Adapula tukang setting yang “menyandra” mikrotik client nya (client hanya diberi read/write akses), saya sudah jelaskan ke ownernya tapi saya tidak didengarkan.  

Suatu ketika semua pelanggan nya tidak bisa konek, setelah saya cek ternyata service PPPoE nya dimatikan dan akses ke router hanya read.

