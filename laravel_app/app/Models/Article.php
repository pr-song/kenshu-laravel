<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function images() {
        return $this->hasMany('App\Models\Image');
    }

    public function tags() {
        return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    }
}
