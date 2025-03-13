<?php

declare (strict_types=1);

namespace plugin\blog\model;

/**
 * 文章内容模型
 * @class PluginBlogContent
 * @package plugin\blog\model
 */
class PluginBlogContent extends Abs
{

    /**
     * 管理集合信息
     * @return \think\model\relation\BelongsTo
     */
    public function series()
    {
        return $this->belongsTo(PluginBlogSeries::class,'series','sign');
    }
}