<?php

namespace Uasoft\Badaso\Module\Post\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Models\User;
use Uasoft\Badaso\Module\Post\Helpers\GetData;
use Uasoft\Badaso\Module\Post\Models\Post;
use Uasoft\Badaso\Traits\FileHandler;

class PostController extends Controller
{
    use FileHandler;

    public function browse(Request $request)
    {
        try {
            $request->validate([
                'order_field' => 'nullable|string',
                'order_direction' => 'nullable|string|in:desc,asc',
                'category' => 'nullable|exists:Uasoft\Badaso\Module\Post\Models\Category,slug',
                'tag' => 'nullable|exists:Uasoft\Badaso\Module\Post\Models\Tag,slug',
                'page' => 'sometimes|required|integer',
                'limit' => 'sometimes|required|integer',
                'search' => 'nullable|string',
            ]);

            $data['posts'] = [];
            $tag = $request->input('tag');
            $category = $request->input('category');
            $search = $request->input('search');

            $posts = Post::with('category.parent', 'tags', 'user:id,name')
                ->when($tag, function ($query, $tag) {
                    return $query->whereHas('tags', function ($q) use ($tag) {
                        $q->where('slug', $tag)->orWhere('title', $tag);
                    });
                })
                ->when($category, function ($query, $category) {
                    return $query->whereHas('category', function ($q) use ($category) {
                        $q->where('slug', $category)->orWhere('title', $category);
                    });
                })
                ->when($search, function ($query, $search) {
                    return $query->where('title', 'LIKE', '%'.$search.'%')
                        ->orWhereHas('tags', function ($q) use ($search) {
                            $q->where('slug', $search)->orWhere('title', $search);
                        });
                })
                ->orderBy($request->order_field ?? 'published_at', $request->order_direction ?? 'desc')
                ->paginate($request->limit ?? 10);

            $data['posts'] = $posts->toArray();

            $doc = new \DOMDocument();

            foreach ($data['posts']['data'] as $key => $post) {
                if ($post['thumbnail'] === null) {
                    @$doc->loadHTML($post['content']);
                    $xpath = new \DOMXPath($doc);
                    $src = $xpath->evaluate('string(//img/@src)');
                    $post['thumbnail'] = $src === '' ? null : $src;
                }

                $data['posts']['data'][$key] = $post;
            }

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function browseMostPopularPost(Request $request)
    {
        try {
            $request->validate([
                'page' => 'sometimes|required|integer',
                'limit' => 'sometimes|required|integer',
            ]);

            $data['posts'] = GetData::getPopularPosts(new Post(), $request, ['category.parent', 'tags', 'user:id,name']);

            $doc = new \DOMDocument();

            foreach ($data['posts'] as $key => $post) {

                if ($post['thumbnail'] === null) {
                    @$doc->loadHTML($post['content']);
                    $xpath = new \DOMXPath($doc);
                    $src = $xpath->evaluate('string(//img/@src)');
                    $post['thumbnail'] = $src === '' ? null : $src;
                }

                $data['posts'][$key] = $post;
            }

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function add(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'title' => 'required|string',
                'slug' => 'required|string|max:255|unique:Uasoft\Badaso\Module\Post\Models\Post',
                'content' => 'required|string',
                'meta_title' => 'nullable|string',
                'meta_description' => 'nullable|string',
                'summary' => 'nullable|string',
                'published' => 'required|boolean',
                'tags' => 'nullable|array|exists:Uasoft\Badaso\Module\Post\Models\Tag,id',
                'category' => 'nullable|exists:Uasoft\Badaso\Module\Post\Models\Category,id',
                'thumbnail' => 'nullable',
            ]);

            $doc = new \DOMDocument();

            $post = Post::create([
                'user_id' => auth()->user()->id,
                'parent_id' => $request->parent ?? null,
                'category_id' => $request->category,
                'title' => $request->title,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'slug' => $request->slug,
                'summary' => $request->summary,
                'content' => $request->content,
                'thumbnail' => $request->thumbnail,
                'published' => $request->published,
                'comment_count' => 0,
                'published_at' => $request->published ? (string) now() : null,
            ]);

            $post->tags()->attach($request->tags);

            DB::commit();

            return ApiResponse::success($post);
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Post\Models\Post',
            ]);

            $post = Post::with('category', 'tags', 'user:id,name')->where('id', $request->id)->first();
            $previous = null;
            $next = null;

            if (! isset($post['thumbnail'])) {
                $doc = new \DOMDocument();
                $content = $post->content;
                @$doc->loadHTML($content);
                $xpath = new \DOMXPath($doc);
                $src = $xpath->evaluate('string(//img/@src)');
                $post['thumbnail'] = $src === '' ? null : $src;
            }

            if (! empty($post->published_at)) {
                $previous = Post::with('category', 'tags', 'user:id,name')->where('published_at', '<', $post->published_at)->orderBy('published_at', 'desc')->first();
                $next = Post::with('category', 'tags', 'user:id,name')->where('published_at', '>', $post->published_at)->orderBy('published_at', 'desc')->first();
            }
            $related = Post::with('category', 'tags', 'user:id,name')->where('category_id', $post->category_id)->limit(4)->get();

            $data['post'] = $post->toArray();

            if ($previous) {
                $data['previous'] = $previous->makeHidden(['content'])->toArray();
            } else {
                $data['previous'] = null;
            }

            if ($next) {
                $data['next'] = $next->makeHidden(['content'])->toArray();
            } else {
                $data['next'] = null;
            }

            if ($related) {
                $data['related'] = $related->makeHidden(['content'])->toArray();
            } else {
                $data['related'] = null;
            }

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function readBySlug(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required|exists:Uasoft\Badaso\Module\Post\Models\Post',
            ]);

            $post = Post::with('category.parent', 'tags', 'user:id,name,username,avatar')->where('slug', $request->slug)->first();

            if (! isset($post['thumbnail'])) {
                $doc = new \DOMDocument();
                $content = $post->content;
                @$doc->loadHTML($content);
                $xpath = new \DOMXPath($doc);
                $src = $xpath->evaluate('string(//img/@src)');
                $post['thumbnail'] = $src === '' ? null : $src;
            }

            $previous = Post::with('category', 'tags', 'user:id,name,username,avatar')->where('published_at', '<', $post->published_at)->orderBy('published_at', 'desc')->first();
            $next = Post::with('category', 'tags', 'user:id,name,username,avatar')->where('published_at', '>', $post->published_at)->orderBy('published_at', 'desc')->first();
            $related = Post::with('category', 'tags', 'user:id,name,username,avatar')->where('category_id', $post->category_id)->limit(4)->get();

            $data['post'] = $post->toArray();

            if ($previous) {
                $data['previous'] = $previous->makeHidden(['content'])->toArray();
            } else {
                $data['previous'] = null;
            }

            if ($next) {
                $data['next'] = $next->makeHidden(['content'])->toArray();
            } else {
                $data['next'] = null;
            }

            if ($related) {
                $data['related'] = $related->makeHidden(['content'])->toArray();
            } else {
                $data['related'] = null;
            }

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function author(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|exists:Uasoft\Badaso\Models\User,username',
            ]);

            $data['posts'] = Post::with('category.parent', 'tags')
                ->whereHas('user', function ($query) use ($request) {
                    return $query->where('username', $request->username);
                })
                ->paginate(18)
                ->toArray();
            $data['user'] = User::select(['id', 'name', 'username', 'avatar'])
                ->where('username', $request->username)
                ->firstOrFail();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function edit(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Post\Models\Post',
                'title' => 'required|string',
                'slug' => 'required|string|max:255|exists:Uasoft\Badaso\Module\Post\Models\Post,slug',
                'content' => 'required|string',
                'meta_title' => 'nullable|string',
                'meta_description' => 'nullable|string',
                'summary' => 'nullable|string',
                'published' => 'required|boolean',
                'tags' => 'nullable|array|exists:Uasoft\Badaso\Module\Post\Models\Tag,id',
                'category' => 'nullable|exists:Uasoft\Badaso\Module\Post\Models\Category,id',
                'thumbnail' => 'nullable',
            ]);

            $post = Post::findOrFail($request->id);

            $post->user_id = auth()->user()->id;
            $post->parent_id = $request->parent ?? null;
            $post->category_id = $request->category;
            $post->title = $request->title;
            $post->slug = $request->slug;
            $post->meta_title = $request->meta_title;
            $post->meta_description = $request->meta_description;
            $post->summary = $request->summary;
            $post->content = $request->content;
            $post->published = $request->published;
            $post->thumbnail = $request->thumbnail;
            $post->published_at = $request->published ? (string) now() : null;
            $post->update();
            $post->tags()->sync($request->tags);

            DB::commit();

            return ApiResponse::success($post);
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Post\Models\Post',
            ]);

            $post = Post::findOrFail($request->id);
            $post->tags()->detach();
            $post->delete();

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

    public function deleteMultiple(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required',
            ]);

            $id_list = explode(',', $request->ids);

            DB::beginTransaction();

            foreach ($id_list as $key => $id) {
                $post = Post::findOrFail($id);
                $post->tags()->detach();
                $post->delete();
            }

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

}
