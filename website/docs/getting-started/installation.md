---
sidebar_position: 1
---

# Installation

1. [Install badaso](https://badaso-docs.uatech.co.id/getting-started/installation) first. After that, you can include the Badaso package with the following command.

    For badaso v2.x (Laravel 8)
    ```
    composer require badaso/post-module
    ```

    For badaso v1.x (Laravel 5, 6, 7)
    ```
    composer require badaso/post-module:^1.0
    ```

1. Run the following command.

    ```
    php artisan badaso-post:setup
    php artisan migrate
    composer dump-autoload
    ```

    For badaso v2.x (Laravel 8)
    ```
    php artisan db:seed --class="Database\Seeders\Badaso\Post\BadasoPostModuleSeeder"
    ```

    For badaso v1.x (Laravel 5, 6, 7)
    ```
    php artisan db:seed --class=BadasoPostModuleSeeder
    ```

1. Add the plugins to your `MIX_BADASO_PLUGINS` to `.env`. If you have another plugins installed, include them using delimiter comma (,).

    ```
    MIX_BADASO_PLUGINS=post-module
    ```

1. Add the plugins menu to your `MIX_BADASO_MENU` to `.env`. If you have another menu, include them using delimiter comma (,).

    ```
    MIX_BADASO_MENU=${MIX_DEFAULT_MENU},post-module
    ```

1. Fill the other variables in `.env` file.
    - `MIX_POST_URL_PREFIX=post`
      Prefix for accessing post | optional
    - `MIX_ANALYTICS_ACCOUNT_ID=`
      Account id from google analytics | optional
    - `MIX_ANALYTICS_WEBPROPERTY_ID=`
      Web property id from google analytics | optional
    - `MIX_ANALYTICS_VIEW_ID=`
      View id from google analytics | optional
      
1. Install & compile the JS 
    `npm install && npm run dev`
