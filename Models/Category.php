<?php

namespace Blog\Models;

use Blog\Traits\ResourceReference;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string name
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */
class Category extends Model {
    use ResourceReference;

    protected $table = 'categories';

    public $fillable = [
        'name',
    ];

    protected $appends = [
        '_ref',
    ];

    public function posts(){
        return $this->hasMany(Post::class, 'category', 'id');
    }

}
