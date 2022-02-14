<?php

namespace Uasoft\Badaso\Module\Post\Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;
use Uasoft\Badaso\Helpers\CallHelperTest;
use Uasoft\Badaso\Module\Post\Models\Category;
use Uasoft\Badaso\Module\Post\Models\Post;

class BadasoCategoriesApiTest extends TestCase
{
    public function test_add_category()
    {
        $token = CallHelperTest::login($this);
        $tableCategory = Category::latest()->first();
        $count = 5;
        for ($i = 0; $i < $count; $i++) {
            $request_data = [
                'title'=> 'Example Category',
                'parentId'=> isset($tableCategory->id) ? $tableCategory->id : null,
                'metaTitle'=> 'example',
                'slug'=> Str::random(10),
                'content'=> 'An example of create new category.',
            ];

            $response = $this->withHeader('Authorization', "Bearer $token")->post(CallHelperTest::getApiV1('/category/add'), $request_data);
            $response->assertSuccessful();

            $datas = $response->json('data.id');

            $CategoryDB = Category::find($datas);

            $this->assertTrue($CategoryDB['title'] == $request_data['title']);
            // $this->assertTrue($CategoryDB['parent_id'] == $request_data['parentId']);
            $this->assertTrue($CategoryDB['meta_title'] == $request_data['metaTitle']);
            $this->assertTrue($CategoryDB['slug'] == $request_data['slug']);
            $this->assertTrue($CategoryDB['content'] == $request_data['content']);
        }
    }

    public function test_edit_category()
    {
        $token = CallHelperTest::login($this);
        $tableCategory = Category::latest()->first();
        $request_data = [
            'id' => "$tableCategory->id",
            'title' => Str::random(5),
            'parentId' => $tableCategory->parent_id,
            'metaTitle' => Str::random(5),
            'slug' => "$tableCategory->slug",
            'content' => Str::random(5),
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")->put(CallHelperTest::getApiV1('/category/edit'), $request_data);
        $response->assertSuccessful();

        $datas = $response->json('data.id');
        $CategoryDB = Category::find($datas);

        $this->assertTrue($CategoryDB['title'] == $request_data['title']);
        $this->assertTrue($CategoryDB['parent_id'] == $request_data['parentId']);
        $this->assertTrue($CategoryDB['meta_title'] == $request_data['metaTitle']);
        $this->assertTrue($CategoryDB['slug'] == $request_data['slug']);
        $this->assertTrue($CategoryDB['content'] == $request_data['content']);
    }

    public function test_read_category()
    {
        $tableCategory = Category::latest()->first();

        $response = $this->get(CallHelperTest::getApiV1("/category/read?id={$tableCategory->id}"));
        $response->assertSuccessful();

        $datas = $response->json('data.category');
        $CategoryDB = Category::find($tableCategory->id);

        $this->assertTrue($CategoryDB['title'] == $datas['title']);
        $this->assertTrue($CategoryDB['parent_id'] == $datas['parentId']);
        $this->assertTrue($CategoryDB['meta_title'] == $datas['metaTitle']);
        $this->assertTrue($CategoryDB['slug'] == $datas['slug']);
        $this->assertTrue($CategoryDB['content'] == $datas['content']);
    }

    public function test_category()
    {
        $response = $this->get(CallHelperTest::getApiV1('/category'));
        $response->assertSuccessful();
        $datas = $response->json('data.categories');

        foreach ($datas as $key => $datas) {
            $datas_id = $datas['id'];
            $CategoryDB = Category::find($datas_id);
            $this->assertNotEmpty($CategoryDB);
            $this->assertTrue($CategoryDB['title'] == $datas['title']);
            $this->assertTrue($CategoryDB['parent_id'] == $datas['parentId']);
            $this->assertTrue($CategoryDB['meta_title'] == $datas['metaTitle']);
            $this->assertTrue($CategoryDB['slug'] == $datas['slug']);
            $this->assertTrue($CategoryDB['content'] == $datas['content']);
        }
    }

    public function test_read_slug_category()
    {
        $slug = Category::select('slug')->latest()->first();
        $except = 'true';

        $response = $this->json('GET', CallHelperTest::getApiV1('/category/read-slug'), [
            'slug' => "$slug->slug",
            'except' => $except,
        ]);
        $response->assertSuccessful();
        $CategoryDB = Category::all();
        $datas = $response->json('data.categories');
        foreach ($datas as $key => $datas) {
            $datas_id = $datas['id'];
            $CategoryDB = Category::find($datas_id);
            $this->assertNotEmpty($CategoryDB);
            $this->assertTrue($CategoryDB['title'] == $datas['title']);
            $this->assertTrue($CategoryDB['parent_id'] == $datas['parentId']);
            $this->assertTrue($CategoryDB['meta_title'] == $datas['metaTitle']);
            $this->assertTrue($CategoryDB['slug'] == $datas['slug']);
            $this->assertTrue($CategoryDB['content'] == $datas['content']);
        }
    }

    public function test_delete_category()
    {
        $token = CallHelperTest::login($this);
        $tableCategory = Category::latest()->first();

        $id = [
            'id' => "$tableCategory->id",
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")->delete(CallHelperTest::getApiV1('/category/delete'), $id);
        $response->assertSuccessful();
        $CatergoryId = Category::find($tableCategory->id);

        $this->assertTrue($CatergoryId == 0);
    }

    public function test_delete_multiple_category()
    {
        $token = CallHelperTest::login($this);
        $tableCategory = Category::orderBy('id', 'Desc')->limit(4)->get();

        $ids = [];
        foreach ($tableCategory as $key => $value) {
            $ids[] = $value->id;
        }

        $response = $this->withHeader('Authorization', "Bearer $token")->delete(CallHelperTest::getApiV1('/category/delete-multiple'), [
            'ids' => join(',', $ids),
        ]);
        $response->assertStatus(200);

        $posts = Post::whereIn('id', $ids)->get();
        $posts_count = $posts->count();
        $this->assertTrue($posts_count == 0);
    }
}
