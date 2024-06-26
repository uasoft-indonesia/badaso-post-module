<?php

namespace Uasoft\Badaso\Module\Post\Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;
use Uasoft\Badaso\Helpers\CallHelperTest;
use Uasoft\Badaso\Module\Post\Models\Category;
use Uasoft\Badaso\Module\Post\Models\Post;
use Uasoft\Badaso\Module\Post\Models\Tag;

class BadasoPostModuleApiTest extends TestCase
{
    public function test_add_posts()
    {
        $token = CallHelperTest::login($this);
        $tableCategory = Category::latest()->first();

        $request_data = [
            'title' => 'Example Category',
            'parentId' => null,
            'metaTitle' => 'example',
            'slug' => Str::random(10),
            'content' => 'An example of create new category.',
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")->post(CallHelperTest::getApiV1('/category/add'), $request_data);

        $request_data = [
            'title' => Str::random(10),
            'metaTitle' => Str::random(10),
            'slug' => Str::random(10),
            'content' => Str::random(10),
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")->json('POST', CallHelperTest::getApiV1('/tag/add'), $request_data);
        $response->assertSuccessful();

        $tableTag = Tag::latest()->first();

        $tableCategory = Category::latest()->first();
        $count = 5;
        for ($i = 0; $i < $count; $i++) {
            $request_data = [
                'title' => Str::random(40),
                'slug' => $tableCategory->slug == $tableCategory->slug ? Str::random(40) : $tableCategory->slug,
                'content' => Str::random(40),
                'metaTitle' => Str::random(40),
                'metaDescription' => Str::random(40),
                'summary' => Str::random(40),
                'published' => true,
                'tags' => [
                    $tableTag->id,
                ],
                'category' => $tableCategory->id,
                'thumbnail' => 'https://badaso-web.s3-ap-southeast-1.amazonaws.com/files/shares/1619582634819_badaso.png',
            ];
            $response = $this->withHeader('Aut', "Bearer $token")->post(CallHelperTest::getApiV1('/post/add'), $request_data);
            $response->assertSuccessful();
            $datas = $response->json('data.id');

            $postDB = Post::find($datas);

            $this->assertNotEmpty($postDB);
            $this->assertTrue($request_data['category'] == $postDB['category_id']);
            $this->assertTrue($request_data['title'] == $postDB['title']);
            $this->assertTrue($request_data['slug'] == $postDB['slug']);
            $this->assertTrue($request_data['metaTitle'] == $postDB['meta_title']);
            $this->assertTrue($request_data['metaDescription'] == $postDB['meta_description']);
            $this->assertTrue($request_data['summary'] == $postDB['summary']);
            $this->assertTrue($request_data['content'] == $postDB['content']);
            $this->assertTrue($request_data['thumbnail'] == $postDB['thumbnail']);
            $this->assertTrue($request_data['published'] == $postDB['published']);
        }
    }

    public function test_edit_posts()
    {
        $token = CallHelperTest::login($this);
        $tableCategory = Category::latest()->first();
        $tableTag = Tag::latest()->first();
        $tablePost = Post::latest()->first();
        $request_data = [
            'id' => "$tablePost->id",
            'title' => Str::random(40),
            'slug' => "$tablePost->slug",
            'content' => Str::random(40),
            'metaTitle' => Str::random(40),
            'metaDescription' => Str::random(40),
            'summary' => Str::random(40),
            'published' => true,
            'tags' => [
                $tableTag->id,
            ],
            'category' => "$tableCategory->id",
            'thumbnail' => 'https://img.era.id/N_gmQ0pRGFpWHeUgv5tCEfpvUBGhW5OOi_QM5snA0PM/rs:fill:1280:720/g:sm/bG9jYWw6Ly8vcHVibGlzaGVycy8zNzY0My8yMDIwMDkxMTA5MzUtbWFpbi5jcm9wcGVkXzE1OTk3OTE3OTYuY3JvcHBlZF8xNTk5NzkxODQxLnBuZw.jpg',
        ];
        $response = $this->withHeader('Authorization', "Bearer $token")->put(CallHelperTest::getApiV1('/post/edit'), $request_data);
        $response->assertSuccessful();
        $datas = $response->json('data.id');
        $postDB = Post::find($datas);

        $this->assertNotEmpty($postDB);
        $this->assertTrue($request_data['id'] == $postDB['id']);
        $this->assertTrue($request_data['category'] == $postDB['category_id']);
        $this->assertTrue($request_data['title'] == $postDB['title']);
        $this->assertTrue($request_data['slug'] == $postDB['slug']);
        $this->assertTrue($request_data['metaTitle'] == $postDB['meta_title']);
        $this->assertTrue($request_data['metaDescription'] == $postDB['meta_description']);
        $this->assertTrue($request_data['summary'] == $postDB['summary']);
        $this->assertTrue($request_data['content'] == $postDB['content']);
        $this->assertTrue($request_data['thumbnail'] == $postDB['thumbnail']);
        $this->assertTrue($request_data['published'] == $postDB['published']);
    }

    public function test_browse_posts()
    {
        $token = CallHelperTest::login($this);

        $tablePost = Post::latest()->first();
        $response = $this->withHeader('Authorization', "Bearer $token")->get(CallHelperTest::getApiV1("/post/read?id={$tablePost->id}"));
        $response->assertSuccessful();

        $datas = $response->json('data.post');
        $postDB = Post::find($tablePost->id);

        $this->assertNotEmpty($postDB);
        $this->assertTrue($datas['id'] == $postDB['id']);
        $this->assertTrue($datas['parentId'] == $postDB['parent_id']);
        $this->assertTrue($datas['categoryId'] == $postDB['category_id']);
        $this->assertTrue($datas['title'] == $postDB['title']);
        $this->assertTrue($datas['slug'] == $postDB['slug']);
        $this->assertTrue($datas['metaTitle'] == $postDB['meta_title']);
        $this->assertTrue($datas['metaDescription'] == $postDB['meta_description']);
        $this->assertTrue($datas['summary'] == $postDB['summary']);
        $this->assertTrue($datas['content'] == $postDB['content']);
        $this->assertTrue($datas['thumbnail'] == $postDB['thumbnail']);
        $this->assertTrue($datas['published'] == $postDB['published']);
        $this->assertTrue($datas['commentCount'] == $postDB['comment_count']);
        $this->assertTrue($datas['publishedAt'] == $postDB['published_at']);
    }

    public function test_read_slug_posts()
    {
        $tablePost = Post::latest()->first();
        $response = $this->get(CallHelperTest::getApiV1("/post/read-slug?slug={$tablePost->slug}"));
        $response->assertSuccessful();

        $datas = $response->json('data.post');
        $postDB = Post::find($tablePost->id);

        $this->assertNotEmpty($postDB);
        $this->assertTrue($datas['id'] == $postDB['id']);
        $this->assertTrue($datas['parentId'] == $postDB['parent_id']);
        $this->assertTrue($datas['categoryId'] == $postDB['category_id']);
        $this->assertTrue($datas['title'] == $postDB['title']);
        $this->assertTrue($datas['slug'] == $postDB['slug']);
        $this->assertTrue($datas['metaTitle'] == $postDB['meta_title']);
        $this->assertTrue($datas['metaDescription'] == $postDB['meta_description']);
        $this->assertTrue($datas['summary'] == $postDB['summary']);
        $this->assertTrue($datas['content'] == $postDB['content']);
        $this->assertTrue($datas['thumbnail'] == $postDB['thumbnail']);
        $this->assertTrue($datas['published'] == $postDB['published']);
        $this->assertTrue($datas['commentCount'] == $postDB['comment_count']);
        $this->assertTrue($datas['publishedAt'] == $postDB['published_at']);
    }

    public function test_popular_posts()
    {
        CallHelperTest::login($this);
        $page = '1';
        $limit = '2';
        $response = $this->get(CallHelperTest::getApiV1("/post/popular?page={$page}&limit={$limit}"));
        $response->assertSuccessful();

        $datas = $response->json('data.posts');

        foreach ($datas as $key => $datas) {
            $postId = $datas['id'];

            $postDB = Post::find($postId);
            $this->assertNotEmpty($postDB);

            $this->assertTrue($datas['id'] == $postDB['id']);
            $this->assertTrue($datas['parentId'] == $postDB['parent_id']);
            $this->assertTrue($datas['categoryId'] == $postDB['category_id']);
            $this->assertTrue($datas['title'] == $postDB['title']);
            $this->assertTrue($datas['slug'] == $postDB['slug']);
            $this->assertTrue($datas['metaTitle'] == $postDB['meta_title']);
            $this->assertTrue($datas['metaDescription'] == $postDB['meta_description']);
            $this->assertTrue($datas['summary'] == $postDB['summary']);
            $this->assertTrue($datas['content'] == $postDB['content']);
            $this->assertTrue($datas['thumbnail'] == $postDB['thumbnail']);
            $this->assertTrue($datas['published'] == $postDB['published']);
            $this->assertTrue($datas['commentCount'] == $postDB['comment_count']);
            $this->assertTrue($datas['publishedAt'] == $postDB['published_at']);
        }
    }

    public function test_post_posts()
    {
        CallHelperTest::login($this);
        $tableCategory = Category::latest()->first();
        $order_field = 'updated_at';
        $order_direction = 'asc';
        $category = "$tableCategory->slug";
        $tag = "$tableCategory->tag";
        $page = '5';
        $limit = '2';
        $search = 'asd';

        $response = $this->get(CallHelperTest::getApiV1("/post?order_field={$order_field}&order_direction={$order_direction}&category={$category}&tag={$tag}&page={$page}&limit={$limit}&search={$search}"));
        $response->assertSuccessful();
        $datas = $response->json('data.posts.data');

        foreach ($datas as $item => $datas) {
            $postId = $datas['id'];
            $postDB = Post::find($postId);

            $this->assertNotEmpty($postDB);
            $this->assertTrue($datas['id'] == $postDB['id']);
            $this->assertTrue($datas['parentId'] == $postDB['parent_id']);
            $this->assertTrue($datas['categoryId'] == $postDB['category_id']);
            $this->assertTrue($datas['title'] == $postDB['title']);
            $this->assertTrue($datas['slug'] == $postDB['slug']);
            $this->assertTrue($datas['metaTitle'] == $postDB['meta_title']);
            $this->assertTrue($datas['metaDescription'] == $postDB['meta_description']);
            $this->assertTrue($datas['summary'] == $postDB['summary']);
            $this->assertTrue($datas['content'] == $postDB['content']);
            $this->assertTrue($datas['thumbnail'] == $postDB['thumbnail']);
            $this->assertTrue($datas['published'] == $postDB['published']);
            $this->assertTrue($datas['commentCount'] == $postDB['comment_count']);
            $this->assertTrue($datas['publishedAt'] == $postDB['published_at']);
        }
    }

    public function test_delete_posts()
    {
        $token = CallHelperTest::login($this);
        $tablePost = Post::latest()->first();

        $response = $this->withHeader('Authorization', "Bearer $token")->delete(CallHelperTest::getApiV1('/post/delete'), [
            'id' => "$tablePost->id",
        ]);
        $response->assertSuccessful();
        $deleteData = Post::where('id', "$tablePost->id")->get();
        $post_count = $deleteData->count();
        $this->assertTrue($post_count == 0);
    }

    public function test_delete_multiple_posts()
    {
        $token = CallHelperTest::login($this);
        $tablePost = Post::orderBy('id', 'desc')
                    ->limit(4)
                    ->get();

        $ids = [];
        foreach ($tablePost as $key => $value) {
            $ids[] = $value->id;
        }

        $tableCategory = Category::latest()->first();

        $id = [
            'id' => "$tableCategory->id",
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")->delete(CallHelperTest::getApiV1('/category/delete'), $id);
        $response->assertSuccessful();

        $response = $this->withHeader('Authorization', "Bearer $token")->delete(CallHelperTest::getApiV1('/post/delete-multiple'), [
            'ids' => join(',', $ids),
        ]);
        $response->assertStatus(200);
        $tableTag = Tag::latest()->first();
        $request_data = [
            'id' => "$tableTag->id",
        ];
        $response = $this->withHeader('Authorization', "Bearer $token")->json('DELETE', CallHelperTest::getApiV1('/tag/delete'), $request_data);

        $posts = Post::whereIn('id', $ids)->get();
        $posts_count = $posts->count();
        $this->assertTrue($posts_count == 0);
    }
}
