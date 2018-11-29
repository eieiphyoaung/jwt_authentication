<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class Article extends Model
{
    protected $fillable=[
        'title',
        'body'
    ];
    //
}
