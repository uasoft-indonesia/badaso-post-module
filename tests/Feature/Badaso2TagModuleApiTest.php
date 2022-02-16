<?php

namespace Uasoft\Badaso\Module\Post\Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;
use Uasoft\Badaso\Helpers\CallHelperTest;
use Uasoft\Badaso\Module\Post\Models\Tag;

class BadasoTagModuleApiTest extends TestCase
{
    public function test_add_tags()
    {
        $token = CallHelperTest::getTokenUserAdminAuthorizeBearer();
        $count = 5;
        for ($i = 0; $i < $count; $i++) {
            $request_data = [
                'title' => Str::random(10),
                'metaTitle' => Str::random(10),
                'slug' => Str::random(10),
                'content' => Str::random(10),
            ];

            $response = $this->withHeader('Authorization', "$token")->json('POST', CallHelperTest::getApiV1('/tag/add'), $request_data);
            $response->assertSuccessful();

            $datas = $response->json('data');

            $this->assertTrue($datas['title'] == $request_data['title']);
            $this->assertTrue($datas['slug'] == $request_data['slug']);
            $this->assertTrue($datas['content'] == $request_data['content']);
            $this->assertTrue($datas['metaTitle'] == $request_data['metaTitle']);
        }
    }

    public function test_edit_tag()
    {
        $token = CallHelperTest::getTokenUserAdminAuthorizeBearer();
        $tableTag = Tag::latest()->first();
        $count = 5;
        $request_data = [
            'id' => "$tableTag->id",
            'title' => Str::random(10),
            'metaTitle' => Str::random(10),
            'slug' => "$tableTag->slug",
            'content' => Str::random(10),
        ];

        $response = $this->withHeader('Authorization', "$token")->json('PUT', CallHelperTest::getApiV1('/tag/edit'), $request_data);
        $response->assertSuccessful();

        $datas = $response->json('data');

        $this->assertTrue($datas['title'] == $request_data['title']);
        $this->assertTrue($datas['slug'] == $request_data['slug']);
        $this->assertTrue($datas['content'] == $request_data['content']);
        $this->assertTrue($datas['metaTitle'] == $request_data['metaTitle']);
    }

    public function test_delete_tag()
    {
        $token = CallHelperTest::getTokenUserAdminAuthorizeBearer();
        $tableTag = Tag::latest()->first();
        $request_data = [
            'id' => "$tableTag->id",
        ];
        $response = $this->withHeader('Authorization', "$token")->json('DELETE', CallHelperTest::getApiV1('/tag/delete'), $request_data);

        $tagDB = Tag::where('id', $tableTag->id)->get();

        $this->assertTrue($tagDB->count() == 0);
    }

    public function test_tag_tag()
    {
        CallHelperTest::login($this);
        $tableTag = Tag::latest()->first();
        $order_field = 'updated_at';
        $order_direction = 'asc';
        $Tag = "$tableTag->slug";
        $tag = "$tableTag->tag";
        $page = '5';
        $limit = '2';
        $search = 'asd';

        $response = $this->json('GET', CallHelperTest::getApiV1('/tag'));
        $response->assertSuccessful();

        $datas = $response->json('data.tags');

        foreach ($datas as $item => $datas) {
            $tagId = $datas['id'];
            $tagDB = Tag::find($tagId);

            $this->assertNotEmpty($tagDB);
            $this->assertTrue($datas['id'] == $tagDB['id']);
            $this->assertTrue($datas['title'] == $tagDB['title']);
            $this->assertTrue($datas['metaTitle'] == $tagDB['meta_title']);
            $this->assertTrue($datas['slug'] == $tagDB['slug']);
            $this->assertTrue($datas['title'] == $tagDB['title']);
            $this->assertTrue($datas['content'] == $tagDB['content']);
        }
    }

    public function test_read_tag()
    {
        $token = CallHelperTest::getTokenUserAdminAuthorizeBearer();
        $tableTag = Tag::latest()->first();
        $request_data = [
            'id' => "$tableTag->id",
        ];
        $response = $this->json('GET', CallHelperTest::getApiV1('/tag/read'), $request_data);
        $response->assertSuccessful();
        $tagDB = Tag::find($tableTag->id);

        $datas = $response->json('data.tags');

        $this->assertTrue($datas['id'] == $tagDB['id']);
        $this->assertTrue($datas['title'] == $tagDB['title']);
        $this->assertTrue($datas['slug'] == $tagDB['slug']);
        $this->assertTrue($datas['content'] == $tagDB['content']);
        $this->assertTrue($datas['metaTitle'] == $tagDB['meta_title']);
    }

    public function test_read_slug_tag()
    {
        $token = CallHelperTest::getTokenUserAdminAuthorizeBearer();
        $tableTag = Tag::latest()->first();
        $request_data = [
            'slug' => "$tableTag->slug",
        ];
        $response = $this->json('GET', CallHelperTest::getApiV1('/tag/read-slug'), $request_data);
        $response->assertSuccessful();
        $tagDB = Tag::find($tableTag->id);

        $datas = $response->json('data.tags');

        $this->assertTrue($datas['id'] == $tagDB['id']);
        $this->assertTrue($datas['title'] == $tagDB['title']);
        $this->assertTrue($datas['slug'] == $tagDB['slug']);
        $this->assertTrue($datas['content'] == $tagDB['content']);
        $this->assertTrue($datas['metaTitle'] == $tagDB['meta_title']);
    }

    public function test_delete_multiple_tag()
    {
        $token = CallHelperTest::getTokenUserAdminAuthorizeBearer();
        $tableTag = Tag::orderBy('id', 'desc')
            ->limit(3)
            ->get();

        $ids = [];
        foreach ($tableTag as $key => $value) {
            $ids[] = $value->id;
        }

        $response = $this->withHeader('Authorization', "$token")->delete(CallHelperTest::getApiV1('/tag/delete-multiple'), [
            'ids' => join(',', $ids),
        ]);
        $response->assertSuccessful();

        $posts = Tag::whereIn('id', $ids)->get();
        $posts_count = $posts->count();
        $this->assertTrue($posts_count == 0);
    
    }
}
