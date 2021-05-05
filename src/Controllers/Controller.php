<?php

namespace Uasoft\Badaso\Module\Blog\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use ReflectionClass;
use Uasoft\Badaso\Facades\Badaso;
use Uasoft\Badaso\Helpers\CaseConvert;
use Uasoft\Badaso\Helpers\GetData;
use Uasoft\Badaso\Traits\FileHandler;

abstract class Controller extends BaseController
{
    use FileHandler;

    public function getSlug(Request $request)
    {
        if (isset($this->slug)) {
            $slug = $this->slug;
        } else {
            $slug = explode('.', $request->route()->getName())[1];
        }

        return $slug;
    }

    public function isAuthorize($method, $data_type)
    {
        if ($user = auth()->user()) {
            $permissions = DB::SELECT('
                SELECT *
                FROM permissions p
                JOIN role_permissions rp ON p.id = rp.permission_id
                JOIN roles r ON rp.role_id  = r.id
                JOIN user_roles ur ON r.id = ur.role_id
                JOIN users u ON ur.user_id = u.id
                WHERE u.id = :user_id
                AND p.key = :permission
            ', [
                'user_id' => $user->id,
                'permission' => $method.'_'.$data_type->name,
            ]);

            if (count($permissions) > 0) {
                return true;
            }
        }

        return true;
    }
}
