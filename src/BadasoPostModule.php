<?php

namespace Uasoft\Badaso\Module\Post;

class BadasoPostModule
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
