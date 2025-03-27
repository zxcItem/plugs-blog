<?php

declare (strict_types=1);

namespace plugin\blog\service;

use think\admin\Exception;
use think\admin\Service;

/**
 * 基础方法
 * Class ConfigService
 * @package plugin\blog\service
 */
class ConfigService extends Service
{
    /**
     * 商城配置缓存名
     * @var string
     */
    private static $skey = 'plugin.blog.config';

    /**
     * 跳转规则定义
     * @var string[]
     */
    const rules = [
        '#'  => ['name' => '不跳转'],
        'LK' => ['name' => '自定义链接'],
        'JH' => ['name' => '文章分类页','node' => 'plugin-blog/news.type/select'],
        'WZ' => ['name' => '文章详情页', 'node' => 'plugin-blog/news.item/select'],
    ];

    /**
     * 广告位规则
     */
    const location = [
        'index_content_right'  => '首页内容侧边-多项',
        'index_content_bottom' => '首页文章底部-单项',
        'news_info_right'   => '文章详情侧边-多项',
        'news_info_bottom'  => '文章详情底部-单项',
    ];

    /**
     * 读取配置参数
     * @param string|null $name
     * @param $default
     * @return array|mixed|null
     * @throws Exception
     */
    public static function get(?string $name = null, $default = null)
    {
        $syscfg = sysvar(self::$skey) ?: sysvar(self::$skey, sysdata(self::$skey));
        return is_null($name) ? $syscfg : ($syscfg[$name] ?? $default);
    }

    /**
     * 配置参数
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public static function set(array $data)
    {
        return sysdata(self::$skey, $data);
    }
}