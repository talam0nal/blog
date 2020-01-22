<?php

namespace App;

use App\Like;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'post_id',
        'ip',
    ];

    public static function getCountLike($id)
    {
        return Like::where('post_id', $id)->count();
    }
}