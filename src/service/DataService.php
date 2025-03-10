<?php

declare (strict_types=1);

namespace plugin\blog\service;

use plugin\blog\model\PluginBlogNavigation;
use think\admin\Service;

/**
 * 基础方法
 * Class DataService
 * @package plugin\blog\service
 */
class DataService extends Service
{

    /**
     * 获取首页导航
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getNavigation()
    {
        return PluginBlogNavigation::mk()->where('status',1)->field('title,url')->select()->map(function ($item){
            if ($item['url']){
                if ($item['url'] == '#') {
                    $item['url'] = '/';
                }else{
                    $array = explode("#", $item['url']);
                    $item['url'] = $array[1];
                }
            }
            return $item;
        })->toArray();
    }
}