<?php

declare (strict_types=1);

namespace plugin\blog\service;

use plugin\blog\model\PluginBlogContent;
use plugin\blog\model\PluginBlogNavigation;
use think\admin\Service;

/**
 * 文章
 * Class NewsService
 * @package plugin\blog\service
 */
class NewsService extends Service
{

    /**
     * 获取首页导航
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getNewsList()
    {
        $query = PluginBlogContent::mQuery()->like('title')->equal('code');
        $query =  $query->where(['status' => 1])
            ->field('title,code,cover,describe,update_at,views,likes,mark')
            ->order('sort desc,id desc')
            ->page(true, false, false, 5);

        return $query;
    }
}