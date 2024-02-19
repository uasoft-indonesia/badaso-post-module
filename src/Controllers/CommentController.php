<?php

namespace Uasoft\Badaso\Module\Post\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Post\Models\Comment;
use Uasoft\Badaso\Module\Post\Models\Post;

class CommentController extends Controller
{
    public function browse()
    {
        try {
            $comments = Comment::with('post', 'user:id,name')->get();

            $data['comments'] = $comments->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function getCommentByPostSlug(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required|exists:Uasoft\Badaso\Module\Post\Models\Post,slug',
                'page' => 'required|integer',
                'per_page' => 'nullable|integer',
                'sort' => 'nullable|string|in:asc,desc',
            ]);

            $comments = Comment::with('user:id,name,avatar', 'children.user:id,name,avatar')
                ->whereHas('post', function (Builder $query) use ($request) {
                    $query->where('slug', $request->slug);
                })
                ->where('parent_id', null)
                ->orderBy('created_at', $request->sort ?? 'desc')
                ->paginate($request->per_page);

            $data['comments'] = $comments->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function add(Request $request)
    {
        DB::beginTransaction();

        try {
            if (Auth::check()) {
                $request->validate([
                    'post_id' => 'required|exists:Uasoft\Badaso\Module\Post\Models\Post,id',
                    'parent_id' => 'nullable|exists:Uasoft\Badaso\Module\Post\Models\Comment,id',
                    'content' => 'required|string',
                ]);

                $post = Post::find($request->post_id);
                $comment = Comment::create([
                    'post_id' => $request->post_id,
                    'parent_id' => $request->parent_id ?? null,
                    'user_id' => auth()->user()->id,
                    'content' => $request->content,
                ]);

                $post->comment_count += 1;
                $post->save();

                $comment_with_user = Comment::where('id', $comment->id)->with('user:id,name,avatar')->first();

                $comment_with_user = json_decode(json_encode($comment_with_user));

                DB::commit();

                return ApiResponse::success($comment_with_user);
            } else {
                $request->validate([
                    'post_id' => 'required|exists:Uasoft\Badaso\Module\Post\Models\Post,id',
                    'parent_id' => 'nullable|exists:Uasoft\Badaso\Module\Post\Models\Comment,id',
                    'user_id' => 'nullable',
                    'content' => 'required|string',
                    'guest_name' => 'required|string|max:255',
                    'guest_email' => 'required|string|email|max:255',
                ]);

                $post = Post::find($request->post_id);
                $comment = Comment::create([
                    'post_id' => $request->post_id,
                    'parent_id' => $request->parent_id ?? null,
                    'user_id' => null,
                    'guest_name' => $request->guest_name,
                    'guest_email' => $request->guest_email,
                    'content' => $request->content,
                ]);

                $post->comment_count += 1;
                $post->save();

                $comment_with_user = Comment::where('id', $comment->id)->first();

                $comment_with_user = json_decode(json_encode($comment_with_user));

                DB::commit();

                return ApiResponse::success($comment_with_user);
            }
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Post\Models\Comment',
            ]);

            $comment = Comment::with('post', 'user:id,name', 'parent', 'children')->where('id', $request->id)->first();

            $data['comment'] = $comment->toArray();

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
                'id' => 'required|exists:Uasoft\Badaso\Module\Post\Models\Comment,id',
                'post_id' => 'required|exists:Uasoft\Badaso\Module\Post\Models\Post,id',
                'parent_id' => 'nullable|exists:Uasoft\Badaso\Module\Post\Models\Comment,id',
                'content' => 'required|string',
                'approved' => 'required',
            ]);

            $comment = Comment::findOrFail($request->id);

            $comment->update([
                'post_id' => $request->post_id,
                'parent_id' => $request->parent_id ?? null,
                'content' => $request->content,
                'approved' => $request->approved,
            ]);

            DB::commit();

            return ApiResponse::success($comment);
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
                'id' => 'required|exists:Uasoft\Badaso\Module\Post\Models\Comment,id',
            ]);

            $comment = Comment::findOrFail($request->id);
            $comment->delete();

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
                $comment = Comment::findOrFail($id);
                $comment->delete();
            }

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }
}
