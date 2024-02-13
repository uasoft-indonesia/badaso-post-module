<?php

namespace Uasoft\Badaso\Module\Post\Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Uasoft\Badaso\Helpers\CallHelperTest;
use Uasoft\Badaso\Models\User;
use Uasoft\Badaso\Module\Post\Models\Category;
use Uasoft\Badaso\Module\Post\Models\Comment;
use Uasoft\Badaso\Module\Post\Models\Post;
use Uasoft\Badaso\Module\Post\Models\Tag;

class BadasoCommentsApiTest extends TestCase
{
    public function test_add_comments()
    {
        $token = CallHelperTest::login($this);
        $tableCategory = Category::latest()->first();

        $request_data = [
            'title' => 'Example Category',
            'parentId' => isset($tableCategory->id) ? $tableCategory->id : null,
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
        $request_data = [
            'title' => Str::random(40),
            'slug' => $tableCategory->slug,
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
        $response = $this->withHeader('Authorization', "Bearer $token")->post(CallHelperTest::getApiV1('/post/add'), $request_data);
        $tablePost = Post::latest()->first();

        $tableComment = Comment::latest()->first();
        $count = 5;
        for ($i = 0; $i < $count; $i++) {
            $request_data = [
                'postId' => isset($tablePost->id) ? $tablePost->id : 1,
                'parentId' => isset($tableComment->id) ? $tableComment->id : null,
                'content' => 'Lorem ipsum dolor sit amet',
                'approved' => rand(0, 1),
            ];

            $response = $this->withHeader('Authorization', "Bearer $token")->json('POST', CallHelperTest::getApiV1('/comment/add'), $request_data);
            $response->assertSuccessful();

            $datas = $response->json('data');

            $this->assertNotEmpty($datas);
            $this->assertTrue($datas['postId'] == $request_data['postId']);
            $this->assertTrue($datas['parentId'] == $request_data['parentId']);
            $this->assertTrue($datas['content'] == $request_data['content']);
        }
    }

    public function test_add_comment_guest()
    {
        $tableCategory = Category::latest()->first();

        $category = Category::create([
            'title' => 'Example Category Guest',
            'parentId' => isset($tableCategory->id) ? $tableCategory->id : null,
            'metaTitle' => 'example',
            'slug' => Str::random(10),
            'content' => 'An example of create new category for guest.',
        ]);

        $tag = Tag::create([
            'title' => Str::random(10),
            'metaTitle' => Str::random(10),
            'slug' => Str::random(10),
            'content' => Str::random(10),
        ]);

        $name = Str::uuid();
        $user = User::create([
            'name' => $name,
            'username' => $name,
            'email' => $name.'@mail.com',
            'password' => Hash::make('secret'),
            'avatar' => 'photos/shares/default-user.png',
            'additional_info' => null,
        ]);

        $post = Post::create([
            'user_id' => $user->id,
            'title' => Str::random(40),
            'slug' => $category->slug,
            'content' => Str::random(40),
            'metaTitle' => Str::random(40),
            'metaDescription' => Str::random(40),
            'summary' => Str::random(40),
            'published' => true,
            'tags' => [
                $tag->id,
            ],
            'category_id' => $category->id,
            'thumbnail' => 'https://badaso-web.s3-ap-southeast-1.amazonaws.com/files/shares/1619582634819_badaso.png',
            'comment_count' => 0,
            'published_at' => (string) now(),
        ]);

        $tableComment = Comment::latest()->first();
        $count = 5;

        for ($i = 0; $i < $count; $i++) {
            $request_data = [
                'postId' => $post->id,
                'parentId' => isset($tableComment->id) ? $tableComment->id : null,
                'userId' => null,
                'guestName' => Str::random(10),
                'guestEmail' => Str::random(10).'@gmail.com',
                'content' => 'Lorem ipsum dolor sit amet',
                'approved' => rand(0, 1),
            ];

            $response = CallHelperTest::withAuthorizeBearer($this)->json('POST', CallHelperTest::getApiV1('/comment/add'), $request_data);
            $response->assertSuccessful();

            $datas = $response->json('data');

            $this->assertNotEmpty($datas);
            $this->assertTrue($datas['postId'] == $request_data['postId']);
            $this->assertTrue($datas['parentId'] == $request_data['parentId']);
            $this->assertTrue($datas['guestName'] == $request_data['guestName']);
            $this->assertTrue($datas['guestEmail'] == $request_data['guestEmail']);
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
            'approved' => rand(0, 1),
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")->json('PUT', CallHelperTest::getApiV1('/comment/edit'), $request_data);
        $response->assertSuccessful();

        $datas = $response->json('data');
        $this->assertNotEmpty($datas);
        $this->assertTrue($datas['postId'] == $request_data['postId']);
        $this->assertTrue($datas['parentId'] == $request_data['parentId']);
        $this->assertTrue($datas['content'] == $request_data['content']);
        $this->assertTrue($datas['approved'] == $request_data['approved']);
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
    }

    public function test_delete_multiple_comment()
    {
        $token = CallHelperTest::login($this);
        $tableComment = Comment::orderBy('id', 'desc')
            ->limit(4)
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

        $tablePost = Post::latest()->first();
        $response = $this->withHeader('Authorization', "Bearer $token")->delete(CallHelperTest::getApiV1('/post/delete'), [
            'id' => "$tablePost->id",
        ]);
        $response->assertSuccessful();

        $tableCategory = Category::latest()->first();

        $id = [
            'id' => "$tableCategory->id",
        ];

        $tableTag = Tag::latest()->first();
        $request_data = [
            'id' => "$tableTag->id",
        ];
        $response = $this->withHeader('Authorization', "Bearer $token")->json('DELETE', CallHelperTest::getApiV1('/tag/delete'), $request_data);

        $response = $this->withHeader('Authorization', "Bearer $token")->delete(CallHelperTest::getApiV1('/category/delete'), $id);
        $response->assertSuccessful();
    }
}
