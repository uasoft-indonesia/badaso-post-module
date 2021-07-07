<?php

namespace Uasoft\Badaso\Module\Post\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'id',
        'title',
        'meta_title',
        'slug',
        'content',
    ];

    protected $hidden = ['pivot'];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), (string) Str::uuid());
        });
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }
}
