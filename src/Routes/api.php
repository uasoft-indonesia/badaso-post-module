<?php

use Uasoft\Badaso\Middleware\ApiRequest;
use Uasoft\Badaso\Middleware\BadasoCheckPermissions;

$api_route_prefix = \config('badaso.api_route_prefix');

Route::group(['prefix' => $api_route_prefix, 'namespace' => 'Uasoft\Badaso\Module\Blog\Controllers', 'as' => 'badaso.', 'middleware' => [ApiRequest::class]], function () {
    Route::group(['prefix' => 'module/blog/v1'], function () {
        Route::group(['prefix' => 'post'], function () {
            Route::get('/', 'PostController@browse');
            Route::get('/browse-analytics', 'PostController@browseWithAnalytics')->middleware(BadasoCheckPermissions::class.':browse_posts');
            Route::get('/popular', 'PostController@browseMostPopularPost');
            Route::get('/read', 'PostController@read')->middleware(BadasoCheckPermissions::class.':read_posts');
            Route::get('/read-slug', 'PostController@readBySlug');
            Route::post('/add', 'PostController@add')->middleware(BadasoCheckPermissions::class.':add_posts');
            Route::put('/edit', 'PostController@edit')->middleware(BadasoCheckPermissions::class.':edit_posts');
            Route::delete('/delete', 'PostController@delete')->middleware(BadasoCheckPermissions::class.':delete_posts');
            Route::delete('/delete-multiple', 'PostController@deleteMultiple')->middleware(BadasoCheckPermissions::class.':delete_posts');
        });

        Route::group(['prefix' => 'category'], function () {
            Route::get('/', 'CategoryController@browse');
            Route::get('/read', 'CategoryController@read');
            Route::get('/read-slug', 'CategoryController@readBySlug');
            Route::post('/add', 'CategoryController@add')->middleware(BadasoCheckPermissions::class.':add_categories');
            Route::put('/edit', 'CategoryController@edit')->middleware(BadasoCheckPermissions::class.':edit_categories');
            Route::delete('/delete', 'CategoryController@delete')->middleware(BadasoCheckPermissions::class.':delete_categories');
            Route::delete('/delete-multiple', 'CategoryController@deleteMultiple')->middleware(BadasoCheckPermissions::class.':delete_categories');
        });

        Route::group(['prefix' => 'tag'], function () {
            Route::get('/', 'TagController@browse');
            Route::get('/read', 'TagController@read');
            Route::get('/read-slug', 'TagController@readBySlug');
            Route::post('/add', 'TagController@add')->middleware(BadasoCheckPermissions::class.':add_tags');
            Route::put('/edit', 'TagController@edit')->middleware(BadasoCheckPermissions::class.':edit_tags');
            Route::delete('/delete', 'TagController@delete')->middleware(BadasoCheckPermissions::class.':delete_tags');
            Route::delete('/delete-multiple', 'TagController@deleteMultiple')->middleware(BadasoCheckPermissions::class.':delete_tags');
        });

        Route::group(['prefix' => 'comment'], function () {
            Route::get('/', 'CommentController@browse')->middleware(BadasoCheckPermissions::class.':browse_comments');
            Route::get('/post', 'CommentController@getCommentByPostSlug');
            Route::get('/read', 'CommentController@read')->middleware(BadasoCheckPermissions::class.':read_comments');
            Route::post('/add', 'CommentController@add');
            Route::put('/edit', 'CommentController@edit')->middleware(BadasoCheckPermissions::class.':edit_comments');
            Route::delete('/delete', 'CommentController@delete')->middleware(BadasoCheckPermissions::class.':delete_comments');
            Route::delete('/delete-multiple', 'CommentController@deleteMultiple')->middleware(BadasoCheckPermissions::class.':delete_comments');
        });
    });
});
