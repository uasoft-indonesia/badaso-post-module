<?php

namespace Uasoft\Badaso\Module\Post\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = null;

    /**
     * Constructor for setting the table name dynamically.
     */
    public function __construct(array $attributes = [])
    {
        $prefix = config('badaso.database.prefix');
        $this->table = $prefix.'categories';
        parent::__construct($attributes);
    }

    protected $fillable = [
        'id',
        'parent_id',
        'title',
        'meta_title',
        'slug',
        'content',
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }
}
