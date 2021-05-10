<?php

namespace Uasoft\Badaso\Module\Blog\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Blog\Helpers\GetData;
use Uasoft\Badaso\Module\Blog\Models\Category;
use Uasoft\Badaso\Module\Blog\Models\Post;
use Uasoft\Badaso\Module\Blog\Models\Tag;

class PostController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $request->validate([
                'limit' => 'sometimes|required|integer',
                'page' => 'sometimes|required|integer',
                'filter_value' => 'nullable|string',
                'order_field' => 'nullable|string',
                'order_direction' => 'nullable|string',
            ]);

            $data = GetData::getData(new Post, $request->all(), ['category.parent', 'tags', 'user:id,name']);
            $data = GetData::getAnalytics($data);

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
            ]);

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
