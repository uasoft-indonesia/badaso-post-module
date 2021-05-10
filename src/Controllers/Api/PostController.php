<?php

namespace Uasoft\Badaso\Module\Blog\Controllers\Api;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Blog\Models\Category;
use Uasoft\Badaso\Module\Blog\Models\Post;
use Uasoft\Badaso\Module\Blog\Models\Tag;

class PostController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $request->validate([
                'sortby'   => 'nullable|string',
                'sorttype' => 'nullable|string|in:desc,asc',
                'category' => 'nullable|exists:categories,slug',
                'tag'      => 'nullable|exists:tags,slug',
            ]);

            $data['posts'] = [];

            if (isset($request->category) && ! isset($request->tag)) {
                $category = Category::where('slug', $request->category)->first();
                $posts = $category->posts()
                    ->with('tags', 'user:id,name')
                    ->orderBy($request->sortby ?? 'published_at', $request->sorttype ?? 'desc')
                    ->get();
            } elseif (isset($request->tag) && ! isset($request->category)) {
                $tags = Tag::where('slug', $request->tag)->first();
                $posts = $tags->posts()
                    ->with('category.parent', 'tags', 'user:id,name')
                    ->orderBy($request->sortby ?? 'published_at', $request->sorttype ?? 'desc')
                    ->get();
            } elseif (isset($request->tag) && isset($request->category)) {
                $posts = Post::
                    whereHas('category', function (Builder $query) use ($request) {
                        $query->where('slug', $request->category);
                    })
                    ->whereHas('tags', function (Builder $query) use ($request) {
                        $query->where('slug', $request->tag);
                    })
                    ->with('category.parent', 'tags', 'user:id,name')
                    ->orderBy($request->sortby ?? 'published_at', $request->sorttype ?? 'desc')
                    ->get();
            } else {
                $posts = Post::with('category.parent', 'tags', 'user:id,name')
                    ->orderBy($request->sortby ?? 'published_at', $request->sorttype ?? 'desc')
                    ->get();
            }

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

            $posts = Post::with('category', 'tags', 'user:id,name')->where('slug', $request->slug)->first();

            $data['posts'] = $posts->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }
}
