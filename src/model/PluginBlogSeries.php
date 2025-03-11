<?php

declare (strict_types=1);

namespace plugin\blog\model;

/**
 * 内容集合模型
 * @class PluginBlogSeries
 * @package plugin\blog\model
 */
class PluginBlogSeries extends Abs
{

    public static function get()
    {
        return self::mk()->column('title','sign');
    }

    public function news()
    {
        return $this->belongsTo(PluginBlogContent::class,'sign','series');
    }

    public function list()
    {
        return $this->hasMany(PluginBlogContent::class,'series','sign');
    }
}