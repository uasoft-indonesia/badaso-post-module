<?php

namespace Uasoft\Badaso\Module\Blog\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Blog\Models\Tag;
use Uasoft\Badaso\Controllers\Controller;

class TagController extends Controller
{
    public function browse()
    {
        try {
            $tags = Tag::all();

            $data['tags'] = $tags->toArray();

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
                'title'      => 'required|string|max:255',
                'meta_title' => 'nullable|string|max:255',
                'slug'       => 'required|string|max:255|unique:tags',
                'content'    => 'nullable|string',
            ]);

            $tags = Tag::create($request->all());
            $tags = json_decode(json_encode($tags));

            DB::commit();

            return ApiResponse::success($tags);
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|string|size:36|exists:tags,id',
            ]);

            $tags = Tag::findOrFail($request->id);

            $data['tags'] = $tags->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function readBySlug(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required|exists:tags,slug',
            ]);

            $tags = Tag::where('slug', $request->slug)->firstOrFail();

            $data['tags'] = $tags->toArray();

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
                'id'         => 'required|string|size:36|exists:tags,id',
                'title'      => 'required|string|max:255',
                'meta_title' => 'nullable|string|max:255',
                'slug'       => 'required|string|max:255|exists:tags,slug',
                'content'    => 'nullable|string',
            ]);

            $tags = Tag::findOrFail($request->id);
            $tags->update($request->all());

            DB::commit();

            return ApiResponse::success($tags);
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
                'id' => 'required|exists:tags|string',
            ]);

            $tags = Tag::findOrFail($request->id);
            $tags->delete();

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

    public function deleteMultiple(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'ids' => 'required',
            ]);

            $id_list = explode(',', $request->ids);

            foreach ($id_list as $key => $id) {
                $tags = Tag::findOrFail($id);
                $tags->delete();
            }

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }
}
