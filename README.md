## 首先用docker安装一个测试用的单节点elasticsearch

1. 在根目录执行docker-compose up -d

2. 测试 Elasticsearch 是否启动成功: `curl 'http://localhost:9269/?pretty'`
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
1. `composer remove laravel/scout:^7.0`
2. `php artisan vendor:publish`
3. `composer require tamayo/laravel-scout-elastic:^5.0`
4. 修改scout的驱动为elasticsearch
5. 添加es的配置
```
'elasticsearch' => [
    'index' => env('ELASTICSEARCH_INDEX', ''),
    'hosts' => [
        env('ELASTICSEARCH_HOST', ''),
    ],
],
```
6. 增加.env
```
ELASTICSEARCH_INDEX=
ELASTICSEARCH_HOST=
```

## 
