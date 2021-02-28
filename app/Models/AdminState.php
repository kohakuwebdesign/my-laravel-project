<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminState extends Model
{
    use HasFactory;

    protected $fillable = [
        'g_map_api_daily_count',
        'g_map_api_limit',
        'twitter_dog_keyword',
        'instagram_dog_keyword',
        'twitter_cat_keyword',
        'instagram_cat_keyword',
        'instagram_search_limit',
        'twitter_search_limit',
    ];
}
