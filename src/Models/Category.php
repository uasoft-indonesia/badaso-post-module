<?php

namespace Uasoft\Badaso\Module\Post\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'id',
        'parent_id',
        'title',
        'meta_title',
        'slug',
        'content',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), (string) Str::uuid());
        });
    }

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
