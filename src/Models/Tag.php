<?php

namespace Uasoft\Badaso\Module\Post\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = null;

    /**
     * Constructor for setting the table name dynamically.
     */
    public function __construct(array $attributes = [])
    {
        $prefix = config('badaso.database.prefix');
        $this->table = $prefix.'tags';
        parent::__construct($attributes);
    }

    protected $fillable = [
        'id',
        'title',
        'meta_title',
        'slug',
        'content',
    ];

    protected $hidden = ['pivot'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, config('badaso.database.prefix').'post_tag');
    }
}
