---
sidebar_position: 2
---

# Penyiapan Google Analytics

## Mendapatkan kredensial JSON

1. Kunjungi situs  [Google API’s site](https://console.cloud.google.com/) menggunakan akun google anda dan pilih atau buat sebuah projek baru .
 ![Imgur](https://i.imgur.com/PuMoMVM.png)
1. Atur projek API. Klik menu Library dan cari kata kunci "Google Analytics Data API".
 ![Imgur](https://i.imgur.com/5hCgMnF.png)
 ![Imgur](https://imgur.com/PEtz6sk.png)
1. Pilih aktifkan untuk mengaktifkan API.
 ![Imgur](https://imgur.com/JshNpEh.png)
1. Jika Anda belum memiliki akun Analytics sebelumnya, isi form seperti gambar di bawah ini.

    - Kunjungi situs [Analytics site](https://analytics.google.com/analytics/web). Isikan nama akun
    ![Imgur](https://imgur.com/yS7HV3P.png)
    - Isi nama properti, zona waktu pelaporan, dan mata uang.
    ![Imgur](https://imgur.com/UEIJOK3.png)
    - Periksa apa pun tentang bisnis Anda.
    ![Imgur](https://imgur.com/6Rd3FIe.png)
    - Periksa apa pun yang menjadi tujuan bisnis Anda.
    ![Imgur](https://imgur.com/jStlyFx.png)
    - Pilih pengumpulan data untuk mendapatkan ID Pelacakan Analytics
    ![Imgur](https://imgur.com/bCG7FTx.png)

1. Kunjungi situs [Google API](https://console.cloud.google.com/apis/dashboard) dan pilih proyek yang Anda inginkan dari header.
1. Kunjungi situs [Credential](https://console.cloud.google.com/apis/credentials) dan membuat kredensial baru.Click **Create Credentials** dan pilih **Service account**.

![Imgur](https://i.imgur.com/nS7m6rZ.png)

1. Isi form dengan nama akun layanan dan ID akun yang Anda sukai. Setelah itu, klik tombol **Buat** dan klik **Selesai**.

![Imgur](https://i.imgur.com/PhCaP9Z.png)

1. Untuk mendapatkan kredensial akun layanan JSON, tekan edit pada akun layanan yang baru dibuat.
![Imgur](https://i.imgur.com/pXbDdHy.png)

1. Pilih menu **KUNCI** dari tab. Klik Tambahkan Kunci dan pilih **Buat kunci baru**. Setelah itu, pilih JSON dan klik tombol **Buat**.
![Imgur](https://i.imgur.com/oexLid9.png)

1. Setelah Anda membuat kunci, kunci tersebut akan diunduh secara otomatis.
1. Tempatkan kunci .json Anda ke direktori penyimpanan seperti di bawah ini.

```php
📦 Your Project
 ┣ 📂 storage
 ┃ ┣ 📂 app
 ┃ ┃ ┣ 📂 analytics // If the directory doesn't exists, just create it
 ┃ ┃ ┃ ┗ 📜 service-account-credentials.json // Filename must be the same
```

## Memberikan izin ke properti Analytics Anda

1. Kunjungi situs [Google Analytics](http://analytics.google.com/) page.
1. Pilih menu **Admin** dari sidebar. Pilih Manajemen akses properti
![Imgur](https://imgur.com/chIY1ov.png)
![Imgur](https://imgur.com/HlnzQmw.png)
1. Akan muncul jendela baru, setelah itu klik **Tambahkan pengguna**.
![Imgur](https://i.imgur.com/BCVGUH4.png)
1. Buka kredensial yang kita dapatkan sebelumnya, cari `client_email`. Salin emailnya.
![Imgur](https://i.imgur.com/A7CPWQB.png)
1. Tempelkan di kolom **Alamat email** dan pilih izin yang Anda inginkan. **Anda harus memeriksa izin Penampil**. Setelah itu, tekan tombol **Selesai**.
![Imgur](https://imgur.com/ms314Ek.png)

## Mendapatkan ID yang Anda butuhkan.

### ID Akun

1. Pilih menu Admin dari sidebar dan pilih Detail Akun.
![Imgur](https://imgur.com/FXzIwrL.png)

1. Itu dia. 
![Imgur](https://imgur.com/g0cv2if.png)

### Property ID / View ID
1. Pilih menu Admin dari sidebar dan pilih Detail Properti. Itu dia.
![Imgur](https://imgur.com/eELpvws.png)

## Tracking ID
1. Buka menu Beranda Analytics. Itu dia.
![Imgur](https://imgur.com/LByg6fc.png)

### Web Property ID

1. Buka halaman [Google Analytics](http://analytics.google.com/).
2. Lihatlah URL halaman. ID properti web dimulai dengan **p**. Biasanya memiliki 9 karakter. Misalnya: 
https://analytics.google.com/analytics/web/#/p299999997/reports/intelligenthome

   ID properti web untuk akun tersebut adalah 299999997.

![Imgur](https://imgur.com/sW8ZBda.png)
