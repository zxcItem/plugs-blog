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
}