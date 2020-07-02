<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class News extends Model
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
            'news_id' => $this->id,
            'news_title' => $this->title,
            'news_text' => $this->text,
            'news_created_at' => $this->created_at,
            'news_updated_at' => $this->updated_at,
        ];
    }
}
