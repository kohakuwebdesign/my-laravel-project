<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prefecture extends Model
{
    use HasFactory;

    /**
     * Relation with post model
     *
     * @return object
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }
}
