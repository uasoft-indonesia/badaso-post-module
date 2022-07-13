---
sidebar_position: 2
---

# Penyiapan Google Analytics
## Mengaktifkan services Google Analytics
1. Pergi ke [Google Api Console](https://console.cloud.google.com/)
2. Cari 'Google Analytics Api' di kotak pencarian
3. Klik tombol 'enable'
![Screenshot from 2022-07-07 17-27-51](https://user-images.githubusercontent.com/79588035/177752913-e7148b37-5954-4f4c-b135-9c8c80571eef.png)

## Mendapatkan kredensial JSON

1. Pergi ke [Google Analytics](http://analytics.google.com/) halaman.
2. Masuk menggunakan Akun Google.
3. Jika Anda belum memiliki akun Analytics sebelumnya, isi formulir seperti gambar di bawah ini.

    - Isi nama akun. Pada **Account Data Sharing Settings**, centang opsi yang Anda inginkan.
    ![Imgur](https://i.imgur.com/f6grepG.png)
    - Isi nama properti, zona waktu pelaporan dan mata uang.
    ![Imgur](https://i.imgur.com/tqjv2JS.png)
    - Klik **Show advanced options**.
    - Isi URL situs web dengan URL situs Anda. Jangan lupa cek **Create a Universal Analytics property only**.
    ![Imgur](https://i.imgur.com/sBBNTQh.png)
    - Periksa apa pun tentang bisnis Anda.
    ![Imgur](https://i.imgur.com/nEDZcGA.png)
    - Setelah itu, klik **Create** tombol dan modal akan muncul lalu tekan tombol **I Accept**.

4. Pergi ke [Google API](https://console.cloud.google.com/apis/dashboard) dan pilih proyek yang Anda inginkan dari header.
5. Pergi ke [Credential](https://console.cloud.google.com/apis/credentials) dan membuat kredensial baru. Klik **Create Credentials** dan pilih **Service account**.

![Imgur](https://i.imgur.com/nS7m6rZ.png)

6. Isi formulir dengan nama akun layanan dan ID akun yang Anda suka. Setelah itu, klik **Create** dan klik **Done**.

![Imgur](https://i.imgur.com/PhCaP9Z.png)

7. Untuk mendapatkan kredensial akun layanan JSON, tekan edit pada akun layanan yang baru dibuat.
![Imgur](https://i.imgur.com/pXbDdHy.png)

8. pilih **KEYS** menu dari tab. Klik Tambahkan Kunci dan pilih **Create new key**. Setelah itu, pilih JSON dan klik tombol **Create** .
![Imgur](https://i.imgur.com/oexLid9.png)

9. Setelah Anda membuat kunci, itu akan secara otomatis mengunduh kunci.
10. Tempatkan kunci .json Anda ke direktori penyimpanan seperti di bawah ini.

```php
📦 Your Project
 ┣ 📂 storage
 ┃ ┣ 📂 app
 ┃ ┃ ┣ 📂 analytics // Jika direktori tidak ada, buat saja
 ┃ ┃ ┃ ┗ 📜 service-account-credentials.json // Nama file harus sama
```

## Memberikan izin ke properti Analytics Anda

1. Pergi ke halaman[Google Analytics](http://analytics.google.com/).
2. Pilih **Admin** menu dari bilah sisi. Pilih **View User Management**.
![Imgur](https://i.imgur.com/PeKLoZ3.png)
3. Akan muncul jendela baru, setelah itu klik **Add users**.
![Imgur](https://i.imgur.com/BCVGUH4.png)
4. Buka kredensial yang kita dapatkan sebelumnya, cari `client_email`. Salin emailnya.
![Imgur](https://i.imgur.com/A7CPWQB.png)
5. Tempelkan di **Email addresses** bidang dan pilih izin yang Anda inginkan. **You must check the Read & Analyze permissions**. Setelah itu, tekan tombol **Done**.
![Imgur](https://i.imgur.com/gzDv7sb.png)

## Mendapatkan ID yang Anda butuhkan.

### View ID

1. Pilih menu Admin dari sidebar dan pilih Lihat Pengaturan.
![Imgur](https://i.imgur.com/07rzLN4.png)

2. Di sana Anda memilikinya.
![Imgur](https://i.imgur.com/hsLpo0A.png)

### Property ID / Tracking ID

1. Pilih menu Admin dari sidebar dan di sana Anda memilikinya.
![Imgur](https://i.imgur.com/LdY7YVz.png)

### Account ID

1. Pilih menu Admin dari sidebar dan pilih Pengaturan Akun.
![Imgur](https://i.imgur.com/G34Uwxs.png)

2. Di sana Anda memilikinya.
![Imgur](https://i.imgur.com/dCvEycA.png)

### Web Property ID

1. Buka halaman [Google Analytics](http://analytics.google.com/).
2. Lihat URL halaman. ID properti web dimulai dengan **w**. Biasanya memiliki 9 karakter. Sebagai contoh: 
https://analytics.google.com/analytics/web/?authuser=1#/report-home/a000000000w299999997p000000000

   ID properti web untuk akun itu adalah 299999997.

![Imgur](https://i.imgur.com/XWimJm5.png)
