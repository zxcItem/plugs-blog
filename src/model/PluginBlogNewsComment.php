<?php


namespace plugin\blog\model;

/**
 * 文章评论
 * Class PluginBlogNewsComment
 * @package plugin\blog\model
 */
class PluginBlogNewsComment extends Abs
{

    /**
     * 文章标题
     * @return \think\model\relation\BelongsTo
     */
    public function newsTitle()
    {
        return $this->belongsTo(PluginBlogNews::class,'code','code')->bind(['news_title'=>'title']);
    }
}