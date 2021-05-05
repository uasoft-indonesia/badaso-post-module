<?php

namespace Uasoft\Badaso\Module\Blog;

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
