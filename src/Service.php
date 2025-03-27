<?php

declare (strict_types=1);

namespace plugin\blog;

use think\admin\Plugin;

/**
 * 组件注册服务
 * @class Service
 * @package plugin\blog
 */
class Service extends Plugin
{
    /**
     * 定义插件名称
     * @var string
     */
    protected $appName = '博客内容系统';

    /**
     * 定义安装包名
     * @var string
     */
    protected $package = 'xiaochao/plugs-blog';

    /**
     * 插件服务注册
     * @return void
     */
    public function register(): void
    {
        $this->commands([]);
    }

    /**
     * 博客内容系统配置
     * @return array[]
     */
    public static function menu(): array
    {
        $code = self::getAppCode();
        // 设置插件菜单
        return [
            [
                'name' => '参数配置',
                'subs' => [
                    ['name' => '应用参数配置', 'icon' => 'layui-icon layui-icon-read', 'node' => "{$code}/base.config/index"],
                    ['name' => '统计数据管理', 'icon' => 'layui-icon layui-icon-read', 'node' => "{$code}/base.report/index"],
                    ['name' => '首页轮播管理', 'icon' => 'layui-icon layui-icon-read', 'node' => "{$code}/base.banner/index"],
                    ['name' => '首页导航管理', 'icon' => 'layui-icon layui-icon-read', 'node' => "{$code}/base.nav/index"],
                    ['name' => '网页广告信息', 'icon' => 'layui-icon layui-icon-read', 'node' => "{$code}/base.ad/index"],
                ],
            ],
            [
                'name' => '文章管理',
                'subs' => [
                    ['name' => '文章内容管理', 'icon' => 'layui-icon layui-icon-read', 'node' => "{$code}/news.item/index"],
                    ['name' => '文章内容评论', 'icon' => 'layui-icon layui-icon-read', 'node' => "{$code}/news.comment/index"],
                ],
            ]
        ];
    }
}