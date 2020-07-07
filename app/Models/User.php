<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class User extends Model
{
    use HasDateTimeFormatter;

    use Searchable;

    protected $guarded = [];

    public function searchableAs()
    {
        return '_doc';
    }

    // 定义有那些字段需要搜索
    public function toSearchableArray()
    {
        return [
            'uid' => $this->uid,
            'users_name' => $this->name,
            'users_introduction' => $this->introduction,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function products()
    {
        return $this->hasMany(Products::class,'uid','uid');
    }
}
