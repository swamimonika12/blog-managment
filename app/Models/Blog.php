<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

class Blog extends Model
{
    use HasFactory;

    //TABLE
    // public $table = 'blogs';

    //FILLABLES
    protected $fillable = [
        'title',
        'description',
        'img_url'
    ];

    //HIDDEN
    protected $hidden = [];

    //APPENDS
    protected $appends = [];

    //WITH
    protected $with = [];

    //CASTS
    protected $casts = [];

    //RULES
    public static $getListRules=[];

    //RELATIONSHIPS
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function likers()
    {
        return $this->belongsToMany(User::class, Like::class, 'likable_id', 'user_id', 'id', 'id');
    }
    
    //SCOPES
    public function scopeMostLikedFirst($query)
    {
        return $query->withCount(['likers'])->orderBy('likers_count', 'desc');
    }


    //ATTRIBUTES
    //public function getExampleAttribute()
    //{
    //    return $data;
    //}
}
