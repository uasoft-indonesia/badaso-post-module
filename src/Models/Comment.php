<?php

namespace Uasoft\Badaso\Module\Post\Models;

use Illuminate\Database\Eloquent\Model;
use Uasoft\Badaso\Models\User;

class Comment extends Model
{
    protected $table = null;

    /**
     * Constructor for setting the table name dynamically.
     */
    public function __construct(array $attributes = [])
    {
        $prefix = config('badaso.database.prefix');
        $this->table = $prefix.'comments';
        parent::__construct($attributes);
    }

    protected $fillable = [
        'id',
        'post_id',
        'parent_id',
        'user_id',
        'content',
        'approved',
        'guest_name',
        'guest_email',
    ];

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
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
