<?php

namespace Uasoft\Badaso\Module\Blog\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Blog\Helpers\GetData;
use Uasoft\Badaso\Module\Blog\Models\Post;
use Uasoft\Badaso\Traits\FileHandler;

class PostController extends Controller
{
    use FileHandler;

    public function browse(Request $request)
    {
        try {
            $request->validate([
                'order_field'       => 'nullable|string',
                'order_direction'   => 'nullable|string|in:desc,asc',
                'category'          => 'nullable|exists:categories,slug',
                'tag'               => 'nullable|exists:tags,slug',
                'page'              => 'sometimes|required|integer',
                'limit'             => 'sometimes|required|integer',
                'search'            => 'nullable|string',
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
                    return $query->where('title', 'LIKE', '%' . $search . '%')
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

    public function browseWithAnalytics(Request $request)
    {
        try {
            $request->validate([
                'order_field' => 'nullable|string',
                'order_direction' => 'nullable|string',
                'category' => 'nullable|exists:categories,slug',
                'tag'      => 'nullable|exists:tags,slug',
                'page'     => 'sometimes|required|integer',
                'limit' => 'sometimes|required|integer',
                'search'   => 'nullable|string',
            ]);

            $oldest = Post::oldest()->first();
            $data = GetData::getData(new Post, $request->all(), ['category.parent', 'tags', 'user:id,name']);
            $data = GetData::getAnalytics($data, $oldest);

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function browseMostPopularPost(Request $request)
    {
        try {
            $request->validate([
                'page'     => 'sometimes|required|integer',
                'limit' => 'sometimes|required|integer',
            ]);

            $oldest = Post::oldest()->first();
            $data['posts'] = GetData::getPopularPosts(new Post, $request, ['category.parent', 'tags', 'user:id,name'], $oldest);

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
                'title'            => 'required|string',
                'slug'             => 'required|string|max:255|unique:posts',
                'content'          => 'required|string',
                'meta_title'       => 'nullable|string',
                'meta_description' => 'nullable|string',
                'summary'          => 'nullable|string',
                'published'        => 'required|boolean',
                'tags'             => 'required|array|exists:tags,id',
                'category'         => 'required|exists:categories,id',
                'commentCount'     => 'required|integer',
                'thumbnail'        => 'nullable',
            ]);

            $doc = new \DOMDocument();

            $thumbnail = null;

            if (!empty($request->thumbnail)) {
                $thumbnail = '/storage/' . $this->handleUploadFiles([$request->thumbnail])[0];
            }

            $post = Post::create([
                'user_id'          => auth()->user()->id,
                'parent_id'        => $request->parent ?? null,
                'category_id'      => $request->category,
                'title'            => $request->title,
                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
                'slug'             => $request->slug,
                'summary'          => $request->summary,
                'content'          => $request->content,
                'thumbnail'        => $thumbnail,
                'published'        => $request->published,
                'comment_count'    => $request->comment_count,
                'published_at'     => $request->published ? (string) now() : null,
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
                'id' => 'required|string|size:36|exists:posts',
            ]);

            $posts = Post::with('category', 'tags', 'user:id,name')->where('id', $request->id)->first();

            $data['posts'] = $posts->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function readBySlug(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required|exists:posts',
            ]);

            $post = Post::with('category.parent', 'tags', 'user:id,name')->where('slug', $request->slug)->first();

            $doc = new \DOMDocument();

            $content = $post->content;
            @$doc->loadHTML($content);
            $xpath = new \DOMXPath($doc);
            $src = $xpath->evaluate('string(//img/@src)');
            $post['thumbnail'] = $src === '' ? null : $src;

            $data['post'] = $post->toArray();

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
                'id'               => 'required|exists:posts',
                'title'            => 'required|string',
                'slug'             => 'required|string|max:255|exists:posts,slug',
                'content'          => 'required|string',
                'meta_title'       => 'nullable|string',
                'meta_description' => 'nullable|string',
                'summary'          => 'nullable|string',
                'published'        => 'required|boolean',
                'tags'             => 'required|array|exists:tags,id',
                'category'         => 'required|exists:categories,id',
                'commentCount'     => 'required|integer',
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
            $post->comment_count = $request->comment_count;
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
                'id' => 'required|exists:posts',
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
