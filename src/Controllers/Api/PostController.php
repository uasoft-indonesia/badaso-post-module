<?php

namespace Uasoft\Badaso\Module\Blog\Controllers\Api;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Blog\Models\Post;

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
                'page'     => 'required',
                'per_page' => 'nullable',
            ]);

            $data['posts'] = [];

            if (isset($request->category) && ! isset($request->tag)) {
                $posts = Post::
                    whereHas('category', function (Builder $query) use ($request) {
                        $query->where('slug', $request->category);
                    })
                    ->with('category.parent', 'tags', 'user:id,name')
                    ->orderBy($request->sortby ?? 'published_at', $request->sorttype ?? 'desc')
                    ->paginate($request->per_page ?? 10);
            } elseif (isset($request->tag) && ! isset($request->category)) {
                $posts = Post::
                    whereHas('tags', function (Builder $query) use ($request) {
                        $query->where('slug', $request->tag);
                    })
                    ->with('category.parent', 'tags', 'user:id,name')
                    ->orderBy($request->sortby ?? 'published_at', $request->sorttype ?? 'desc')
                    ->paginate($request->per_page ?? 10);
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
                    ->paginate($request->per_page ?? 10);
            } else {
                $posts = Post::with('category.parent', 'tags', 'user:id,name')
                    ->orderBy($request->sortby ?? 'published_at', $request->sorttype ?? 'desc')
                    ->paginate($request->per_page ?? 10);
            }

            $doc = new \DOMDocument();

            foreach ($posts as $key => $post) {
                $content = $post->content;
                @$doc->loadHTML($content);
                $xpath = new \DOMXPath($doc);
                $src = $xpath->evaluate('string(//img/@src)');
                $post['thumbnail'] = $src === '' ? null : $src;
                $data['posts'][$key] = $post->toArray();
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
                'slug' => 'required|exists:posts',
            ]);

            $post = Post::with('category', 'tags', 'user:id,name')->where('slug', $request->slug)->first();

            $doc = new \DOMDocument();

            $content = $post->content;
            @$doc->loadHTML($content);
            $xpath = new \DOMXPath($doc);
            $src = $xpath->evaluate('string(//img/@src)');
            $post['thumbnail'] = $src === '' ? null : $src;

            $data['posts'] = $post->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }
}
