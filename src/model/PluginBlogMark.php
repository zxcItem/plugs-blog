<?php

declare (strict_types=1);

namespace plugin\blog\model;


/**
 * 标签云模型
 * @class PluginBlogMark
 * @package plugin\blog\model
 */
class PluginBlogMark extends Abs
{

    /**
     * 获取所有标签
     * @return array
     */
    public static function items(): array
    {
        return static::mk()->where(['status' => 1])->order('sort desc,id desc')->column('title','sign');
    }
}