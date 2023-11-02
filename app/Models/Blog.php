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

    public function scopeLike($query,$user)
    {
        return $query->withExists(['likes as is_liked' => function ($query) use ($user) {
            return $query->where(DB::raw("count(*) as count"), 'user_id');
        }]);

        // return $query->withExists(['likes as is_liked' => function ($query) use ($user) {
        //     return $query->where('user_id', $user->id)->select(DB::raw("count(*) as count"), 'user_id');
        // }]);
    }


    //ATTRIBUTES
    //public function getExampleAttribute()
    //{
    //    return $data;
    //}
}
