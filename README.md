# @badaso/blog
Zero development for blog system on badaso

# Installation

- Install badaso first. After that, you can include the Badaso package with the following command.

```
composer require uasoft-indonesia/badaso-blog-module:^1.0@alpha
```

- Run the following command.

```
php artisan badaso-blog:setup
php artisan badaso-blog:seed
```

- Add the plugins to your `MIX_BADASO_MODULES` to `.env`. If you have another plugins installed, include them using delimiter comma (,).

```
MIX_BADASO_MODULES=badaso-blog-module
```

- Add the plugins menu to your `MIX_BADASO_MENU` to `.env`. If you have another menu, include them using delimiter comma (,).

```
MIX_BADASO_MENU=admin,badaso-blog-module
```

- Fill the other variables in `.env` file.