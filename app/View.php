<?php

namespace App;

use App\View;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
        'post_id',
        'ip',
    ];

    public static function getCountViews($id)
    {
        return View::where('post_id', $id)->count();
    }
}