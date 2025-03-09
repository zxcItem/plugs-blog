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
                    ['name' => '标签信息管理', 'icon' => 'layui-icon layui-icon-read', 'node' => "{$code}/base.mark/index"],
                    ['name' => '集合信息管理', 'icon' => 'layui-icon layui-icon-read', 'node' => "{$code}/base.series/index"],
                    ['name' => '首页导航管理', 'icon' => 'layui-icon layui-icon-read', 'node' => "{$code}/base.nav/index"],
                ],
            ],
            [
                'name' => '文章管理',
                'subs' => [
                    ['name' => '文章内容管理', 'icon' => 'layui-icon layui-icon-read', 'node' => "{$code}/content.item/index"],
                ],
            ]
        ];
    }
}