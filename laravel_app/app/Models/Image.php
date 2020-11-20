<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = ['id'];

    public function article() {
        return $this->belongsTo('App\Models\Article');
    }
}
