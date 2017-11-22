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
class Post extends Model {
    use ResourceReference;

    protected $table = 'posts';

    public $fillable = [
        'category',
        'title',
        'description',
    ];

    protected $appends = [
        '_ref',
    ];

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category');
    }

}
