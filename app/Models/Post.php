<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_id',
        'text',
        'data_created_at',
        'media_url',
        'embed_tag',
        'is_published',
        'is_deleted',
        'prefecture_id',
        'animal_id',
        'state_id'
    ];

    /**
     * Relation with prefecture model
     *
     * @return object
     */
    public function prefecture()
    {
        return $this->belongsTo('App\Models\Prefecture');
    }

    /**
     * Relation with animal model
     *
     * @return object
     */
    public function animal()
    {
        return $this->belongsTo('App\Models\Animal');
    }

    /**
     * Relation with state model
     *
     * @return object
     */
    public function state()
    {
        return $this->belongsTo('App\Models\State');
    }

    /**
     * Relation with webservice model
     *
     * @return object
     */
    public function webservice()
    {
        return $this->belongsTo('App\Models\Webservice');
    }
}
