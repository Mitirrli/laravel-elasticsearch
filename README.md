# 简单步骤

## 首先用docker安装一个测试用的单节点elasticsearch

1 . 在根目录执行docker-compose up -d

2 . 测试 Elasticsearch 是否启动成功: `curl 'http://localhost:9269/?pretty'`
```
{
  "name" : "c143de843073",
  "cluster_name" : "docker-cluster",
  "cluster_uuid" : "83D7gy_7RJa-7OgAbArN8Q",
  "version" : {
    "number" : "7.8.0",
    "build_flavor" : "default",
    "build_type" : "docker",
    "build_hash" : "757314695644ea9a1dc2fecd26d1a43856725e65",
    "build_date" : "2020-06-14T19:35:50.234439Z",
    "build_snapshot" : false,
    "lucene_version" : "8.5.1",
    "minimum_wire_compatibility_version" : "6.8.0",
    "minimum_index_compatibility_version" : "6.0.0-beta1"
  },
  "tagline" : "You Know, for Search"
}
```

## composer安装elasticsearch扩展
1 . `composer remove laravel/scout:^7.0`

2 . `php artisan vendor:publish`

3 . `composer require tamayo/laravel-scout-elastic:^5.0`

4 . 修改scout的驱动为elasticsearch

5 . 添加es的配置

```
'elasticsearch' => [
    'index' => env('ELASTICSEARCH_INDEX', ''),
    'hosts' => [
        env('ELASTICSEARCH_HOST', ''),
    ],
],
```
6 . 增加.env
```
ELASTICSEARCH_INDEX=
ELASTICSEARCH_HOST=
```

## 下载ik压缩包
1 . 创建索引 `curl -X PUT http://localhost:9269/index`

2 . 查看ik是否生效
```
curl -X GET http://localhost:9269/_analyze -H 'Content-Type:application/json' -d'
{
    "analyzer" : "ik_max_word",
    "text" : "中华人民共和国"
}
'
```
```
结果:
{
    "tokens": [
        {
            "token": "中华人民共和国",
            "start_offset": 0,
            "end_offset": 7,
            "type": "CN_WORD",
            "position": 0
        },
        {
            "token": "中华人民",
            "start_offset": 0,
            "end_offset": 4,
            "type": "CN_WORD",
            "position": 1
        },
        {
            "token": "中华",
            "start_offset": 0,
            "end_offset": 2,
            "type": "CN_WORD",
            "position": 2
        },
        {
            "token": "华人",
            "start_offset": 1,
            "end_offset": 3,
            "type": "CN_WORD",
            "position": 3
        },
        {
            "token": "人民共和国",
            "start_offset": 2,
            "end_offset": 7,
            "type": "CN_WORD",
            "position": 4
        },
        {
            "token": "人民",
            "start_offset": 2,
            "end_offset": 4,
            "type": "CN_WORD",
            "position": 5
        },
        {
            "token": "共和国",
            "start_offset": 4,
            "end_offset": 7,
            "type": "CN_WORD",
            "position": 6
        },
        {
            "token": "共和",
            "start_offset": 4,
            "end_offset": 6,
            "type": "CN_WORD",
            "position": 7
        },
        {
            "token": "国",
            "start_offset": 6,
            "end_offset": 7,
            "type": "CN_CHAR",
            "position": 8
        }
    ]
}
```

3 .
```
curl -X POST http://localhost:9269/index/_mapping -H 'Content-Type:application/json' -d'
{
        "properties": {
            "content": {
                "type": "text",
                "analyzer": "ik_max_word",
                "search_analyzer": "ik_smart"
            }
        }
}'
```

4 . `curl -X POST http://localhost:9269/index/_create/1 -H 'Content-Type:application/json' -d'
     {"content":"美国留给伊拉克的是个烂摊子吗"}
     '`
     
5 . `curl -X POST http://localhost:9269/index/_create/2 -H 'Content-Type:application/json' -d'
     {"content":"公安部：各地校车将享最高路权"}
     '`
     
6 . `curl -X POST http://localhost:9269/index/_create/3 -H 'Content-Type:application/json' -d'
     {"content":"中韩渔警冲突调查：韩警平均每天扣1艘中国渔船"}
     '`
     
7 . `curl -XPOST http://localhost:9269/index/_create/4 -H 'Content-Type:application/json' -d'
     {"content":"中国驻洛杉矶领事馆遭亚裔男子枪击 嫌犯已自首"}
     '`
     
8 . 高亮查询
```
curl -X POST http://localhost:9269/index/_search  -H 'Content-Type:application/json' -d'
{
    "query" : { "match" : { "content" : "中国" }},
    "highlight" : {
        "pre_tags" : ["<tag1>", "<tag2>"],
        "post_tags" : ["</tag1>", "</tag2>"],
        "fields" : {
            "content" : {}
        }
    }
}
'
```
```
结果:
{
    "took": 866,
    "timed_out": false,
    "_shards": {
        "total": 1,
        "successful": 1,
        "skipped": 0,
        "failed": 0
    },
    "hits": {
        "total": {
            "value": 2,
            "relation": "eq"
        },
        "max_score": 0.642793,
        "hits": [
            {
                "_index": "index",
                "_type": "_doc",
                "_id": "3",
                "_score": 0.642793,
                "_source": {
                    "content": "中韩渔警冲突调查：韩警平均每天扣1艘中国渔船"
                },
                "highlight": {
                    "content": [
                        "中韩渔警冲突调查：韩警平均每天扣1艘<tag1>中国</tag1>渔船"
                    ]
                }
            },
            {
                "_index": "index",
                "_type": "_doc",
                "_id": "4",
                "_score": 0.642793,
                "_source": {
                    "content": "中国驻洛杉矶领事馆遭亚裔男子枪击 嫌犯已自首"
                },
                "highlight": {
                    "content": [
                        "<tag1>中国</tag1>驻洛杉矶领事馆遭亚裔男子枪击 嫌犯已自首"
                    ]
                }
            }
        ]
    }
}
```

## 设置model
1 . 设定model
```
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
```
2 . 插入数据

3 . 查询es`curl 'http://localhost:9269/demo/_search'`(demo是定义的Index)

## 安装kibana
1 . `docker-compose增加安装kibana脚本`

2 . 接下来就可以通过0.0.0.0:5661访问kibana了

## es库数据操作
1 . 清空数据`php artisan scout:flush "App\Models\News"`

2 . 导入数据`php artisan scout:import "App\Models\News"`

## 增加命令行调试
1 . `php artisan es:list [type] [query]`

2 . type为类型,可选news、user ; query为待查询字段

## 增加php7.4.7
1 . 进入容器中`docker exec -it mi-php sh`

2 . 开启服务`php -S 0.0.0.0:80`

## 安装laravels
1 . 参考[github](https://github.com/hhxsv5/laravel-s)

## 安装laravelcollective/annotations注解
1 . `composer require plaravelcollective/annotations`

2 . 参考[github](https://github.com/LaravelCollective/annotations)

3 . 
```
Scanning your event handlers, controllers, and models 
can be done manually by using
php artisan event:scan, 
php artisan route:scan, 
or php artisan model:scan respectively. 
In the local environment, you can scan them automatically by setting protected $scanWhenLocal = true
```
4 . `运行 artisan route:scan, 会产生一个路由缓存文件 storage/framework/routes.scanned.php`
