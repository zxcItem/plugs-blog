<?php

declare (strict_types=1);

namespace plugin\blog\model;

/**
 * 文章内容模型
 * @class PluginBlogNews
 * @package plugin\blog\model
 */
class PluginBlogNews extends Abs
{

    /**
     * 管理分类信息
     * @return \think\model\relation\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(PluginBlogNewsType::class,'type','sign');
    }
}