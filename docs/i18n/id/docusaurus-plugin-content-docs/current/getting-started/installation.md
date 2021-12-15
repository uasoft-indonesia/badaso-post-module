---
sidebar_position: 1
---

# Installation

1. [Install badaso](https://badaso-docs.uatech.co.id/getting-started/installation) pertama. Setelah itu, Anda dapat memasukkan paket Badaso dengan perintah berikut.

Untuk badaso v2.x (Laravel 8)
```
composer require badaso/post-module
```

Untuk badaso v1.x (Laravel 5, 6, 7)
```
composer require badaso/post-module:^1.0
```

2. Jalankan perintah berikut.

```
php artisan migrate
php artisan badaso-post:setup
composer dump-autoload
```

Untuk badaso v2.x (Laravel 8)
```
php artisan db:seed --class="Database\Seeders\Badaso\Post\BadasoPostModuleSeeder"
```

Untuk badaso v1.x (Laravel 5, 6, 7)
```
php artisan db:seed --class=BadasoPostModuleSeeder
```

3. Tambahkan plugin ke `MIX_BADASO_MODULES` Anda ke `.env`. Jika Anda memiliki plugin lain yang diinstal, sertakan plugin tersebut menggunakan koma pembatas (,).

```
MIX_BADASO_MODULES=post-module
```

4. Tambahkan menu plugin ke `MIX_BADASO_MENU` Anda ke `.env`. Jika Anda memiliki menu lain, sertakan menu tersebut menggunakan koma pembatas (,).

```
MIX_BADASO_MENU=admin,post-module
```

5. Isi variabel lain dalam file `.env`.
    - `MIX_POST_URL_PREFIX=post`
      Awalan untuk mengakses pos | pilihan
    - `MIX_ANALYTICS_ACCOUNT_ID=`
      ID akun dari google analytics | pilihan
    - `MIX_ANALYTICS_WEBPROPERTY_ID=`
      ID properti web dari google analytics | pilihan
    - `MIX_ANALYTICS_VIEW_ID=`
      Lihat id dari google analytics | pilihan