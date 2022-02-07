<?php

namespace Uasoft\Badaso\Module\Post\Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;
use Uasoft\Badaso\Helpers\CallHelperTest;
use Uasoft\Badaso\Module\Post\Models\Comment;
use Uasoft\Badaso\Module\Post\Models\Post;

class BadasoCommentsApiTest extends TestCase
{
    public function test_add_comments()
    {
        $token = CallHelperTest::login($this);
        $tablePost = Post::latest()->first();
        $tableComment = Comment::latest()->first();
        $count = 5;
        for ($i = 0; $i < $count; $i++) {
            $request_data = [
                'postId'=> isset($tablePost->id) ? $tablePost->id : 1,
                'parentId'=> isset($tableComment->id) ? $tableComment->id : null,
                'content'=> 'Lorem ipsum dolor sit amet',
            ];

            $response = $this->withHeader('Authorazion', "Bearer $token")->json('POST', CallHelperTest::getApiV1('/comment/add'), $request_data);
            $response->assertSuccessful();

            $datas = $response->json('data');

            $this->assertNotEmpty($datas);
            $this->assertTrue($datas['postId'] == $request_data['postId']);
            $this->assertTrue($datas['parentId'] == $request_data['parentId']);
            $this->assertTrue($datas['content'] == $request_data['content']);
        }
    }

    public function test_edit_comment()
    {
        $token = CallHelperTest::login($this);
        $tablePost = Post::latest()->first();
        $tableComment = Comment::latest()->first();
        $request_data = [
            'id' => "$tableComment->id",
            'postId' => $tablePost->id,
            'parentId' => $tableComment->id,
            'content' => Str::random(),
        ];

        $response = $this->withHeader('Authorazion', "Bearer $token")->json('PUT', CallHelperTest::getApiV1('/comment/edit'), $request_data);
        $response->assertSuccessful();

        $datas = $response->json('data');
        $this->assertNotEmpty($datas);
        $this->assertTrue($datas['postId'] == $request_data['postId']);
        $this->assertTrue($datas['parentId'] == $request_data['parentId']);
        $this->assertTrue($datas['content'] == $request_data['content']);
    }

    public function test_delete_comment()
    {
        $token = CallHelperTest::login($this);
        $tableComment = Comment::latest()->first();

        $response = $this->withHeader('Authorization', "Bearer $token")->delete(CallHelperTest::getApiV1('/comment/delete'), [
            'id' => "$tableComment->id",
        ]);

        $response->assertSuccessful();
        $deleteData = Comment::where('id', "$tableComment->id")->get();
        $post_count = $deleteData->count();
        $this->assertTrue($post_count == 0);
    }

    public function test_delete_multiple_comment()
    {
        $token = CallHelperTest::login($this);
        $tableComment = Comment::orderBy('id', 'desc')
            ->limit(2)
            ->get();

        $ids = [];
        foreach ($tableComment as $key => $value) {
            $ids[] = $value->id;
        }

        $response = $this->withHeader('Authorization', "Bearer $token")->delete(CallHelperTest::getApiV1('/comment/delete-multiple'), [
            'ids' => join(',', $ids),
        ]);
        $response->assertStatus(200);

        $posts = Comment::whereIn('id', $ids)->get();
        $posts_count = $posts->count();
        $this->assertTrue($posts_count == 0);
    }

    public function test_comment_comment()
    {
        $token = CallHelperTest::login($this);
        $response = $this->get(CallHelperTest::getApiV1('/comment'));
        $response->assertSuccessful();
        $datas = $response->json('data.comments');

        foreach ($datas as $key => $datas) {
            $datas_id = $datas['id'];
            $CategoryDB = Comment::find($datas_id);
            $this->assertNotEmpty($CategoryDB);
            $this->assertNotEmpty($datas);

            $this->assertTrue($datas['id'] == $CategoryDB['id']);
            $this->assertTrue($datas['postId'] == $CategoryDB['post_id']);
            $this->assertTrue($datas['parentId'] == $CategoryDB['parent_id']);
            $this->assertTrue($datas['content'] == $CategoryDB['content']);
        }
    }

    public function test_post_comment()
    {
        $tablePost = Post::latest()->first();
        $requset_data = [
            'slug' => "$tablePost->slug",
            'page' => '1',
            'per_page' => '2',
            'sort' => '',
        ];
        $response = $this->json('GET', CallHelperTest::getApiV1('/comment/post'), $requset_data);
        $response->assertSuccessful();

        $datas = $response->json('data.comments');
        

    }

    public function test_read_comment()
    {
        $token = CallHelperTest::login($this);
        $tableComment = Comment::latest()->first();
        $requset_data = [
            'id' => $tableComment->id,
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")->json('GET', CallHelperTest::getApiV1('/comment/read'), $requset_data);
        $response->assertSuccessful();

        $datas = $response->json('data.comment');
        $CommentDB = Comment::find($tableComment->id);

        $response->assertStatus(200);
        // $this->assertTrue($datas['id'] == $CommentDB['id']);
        // $this->assertTrue($datas['postId'] == $CommentDB['post_id']);
        // $this->assertTrue($datas['parentId'] == $CommentDB['parent_id']);
        // $this->assertTrue($datas['content'] == $CommentDB['content']);
    }
}
