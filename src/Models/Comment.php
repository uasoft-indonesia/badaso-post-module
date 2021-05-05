<?php

namespace Uasoft\Badaso\Module\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Uasoft\Badaso\Models\User;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'id',
        'post_id',
        'parent_id',
        'user_id',
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
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
