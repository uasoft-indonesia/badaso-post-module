<?php

namespace Uasoft\Badaso\Module\Blog;

use Illuminate\Support\Str;
use Uasoft\Badaso\Models\Configuration;
use Uasoft\Badaso\Models\DataRow;
use Uasoft\Badaso\Models\DataType;
use Uasoft\Badaso\Models\Menu;
use Uasoft\Badaso\Models\MenuItem;
use Uasoft\Badaso\Models\Permission;
use Uasoft\Badaso\Models\Role;
use Uasoft\Badaso\Models\RolePermission;
use Uasoft\Badaso\Models\User;
use Uasoft\Badaso\Models\UserRole;

class BadasoBlogModule
{
    protected $protected_tables = [
        'categories',
        'comments',
        'posts',
        'post_tag',
        'tags',
    ];

    public function getProtectedTables()
    {
        return $this->protected_tables;
    }
}
