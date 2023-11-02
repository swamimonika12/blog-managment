<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Like extends Model
{
    use HasFactory;

    //TABLE
    // public $table = 'blogs';

    //FILLABLES
    protected $fillable = [
        'user_id',
        'likable_id ',
        'likable_type'
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
    public function likable(): MorphTo
    {
        return $this->morphTo();
    }


    //ATTRIBUTES
    //public function getExampleAttribute()
    //{
    //    return $data;
    //}
}
