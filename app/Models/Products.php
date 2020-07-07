<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Products extends Model
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
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'brand' => $this->brand,
            'uid' => $this->uid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
