<?php

namespace Uasoft\Badaso\Module\Blog\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Blog\Models\Comment;

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
                'slug' => 'required|exists:posts,slug',
            ]);

            $comments = Comment::with('user:id,name', 'parent', 'children')
                ->whereHas('post', function (Builder $query) use ($request) {
                    $query->where('slug', $request->slug);
                })
                ->get();

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
                    'post_id'   => 'required|exists:posts,id',
                    'parent_id' => 'nullable|exists:comments,id',
                    'content'   => 'required|string',
                ]);

                $comment = Comment::create([
                    'post_id'   => $request->post_id,
                    'parent_id' => $request->parent_id ?? null,
                    'user_id'   => auth()->user()->id,
                    'post_id'   => $request->post_id,
                    'content'   => $request->content,
                ]);

                $comment = json_decode(json_encode($comment));

                DB::commit();

                return ApiResponse::success($comment);
            } else {
                return ApiResponse::failed(__('badaso-blog::validation.comment.user_not_logged_in'));
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
                'id' => 'required|string|size:36|exists:comments',
            ]);

            $comment = Comment::with('post', 'user:id,name', 'parent', 'children')->first();

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
                'post_id'   => 'required|exists:posts,id',
                'parent_id' => 'nullable|exists:comments,id',
                'content'   => 'required|string',
            ]);

            $comment = Comment::findOrFail($request->id);
            $comment->update([
                'post_id'   => $request->post_id,
                'parent_id' => $request->parent_id ?? null,
                'user_id'   => auth()->user()->id,
                'post_id'   => $request->post_id,
                'content'   => $request->content,
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
                'id' => 'required|exists:comments,id',
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
