<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'preview',
        'text',
        'category_id',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}