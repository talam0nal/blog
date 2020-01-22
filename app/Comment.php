<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'text',
        'user_id',
        'active',
        'post_id',
    ];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

}