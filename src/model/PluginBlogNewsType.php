<?php

declare (strict_types=1);

namespace plugin\blog\model;

/**
 * 文章分类模型
 * @class PluginBlogNewsType
 * @package plugin\blog\model
 */
class PluginBlogNewsType extends Abs
{

    public static function get()
    {
        return self::mk()->column('title','sign');
    }

    public function news()
    {
        return $this->belongsTo(PluginBlogNews::class,'sign','type');
    }

    public function list()
    {
        return $this->hasMany(PluginBlogNews::class,'type','sign');
    }
}