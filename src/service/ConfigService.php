<?php

declare (strict_types=1);

namespace plugin\blog\service;

use think\admin\Service;

/**
 * 基础方法
 * Class ConfigService
 * @package plugin\blog\service
 */
class ConfigService extends Service
{
    /**
     * 跳转规则定义
     * @var string[]
     */
    const rules = [
        '#'  => ['name' => '不跳转'],
        'LK' => ['name' => '自定义链接'],
        'JH' => ['name' => '集合详情页','node' => 'plugin-blog/base.series/select'],
        'WZ' => ['name' => '文章详情页', 'node' => 'plugin-blog/content.item/select'],
    ];

    /**
     * 广告位规则
     */
    const location = [
        'index_content_right'  => '首页内容侧边-多项',
        'index_content_bottom' => '首页文章底部-单项',
        'content_info_right'   => '文章详情侧边-多项',
        'content_info_bottom'  => '文章详情底部-单项',
    ];
}