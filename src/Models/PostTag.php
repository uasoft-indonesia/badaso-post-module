<?php

namespace Uasoft\Badaso\Module\Post\Models;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    protected $table = null;

    /**
     * Constructor for setting the table name dynamically.
     */
    public function __construct(array $attributes = [])
    {
        $prefix = config('badaso.database.prefix');
        $this->table = $prefix.'post_tag';
        parent::__construct($attributes);
    }

    protected $fillable = [
        'id',
        'post_id',
        'tag_id',
    ];
}
