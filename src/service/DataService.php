<?php

declare (strict_types=1);

namespace plugin\blog\service;

use plugin\blog\model\PluginBlogNews;
use plugin\blog\model\PluginBlogNewsMark;
use think\admin\Service;

/**
 * 基础方法
 * Class DataService
 * @package plugin\blog\service
 */
class DataService extends Service
{

    /**
     * 处理文章列表中的标签
     * @param array $list 文章列表
     * @return array 处理后的文章列表
     */
    public static function markList(array $list)
    {
        foreach ($list as &$value) {
            $value['mark'] = self::markInfo($value['mark']);
        }
        return $list;
    }

    /**
     * 文章标签处理
     * @param string|null $mark
     * @return array
     */
    public static function markInfo(string $mark = null)
    {
        // 缓存键
        $ckey = 'PluginContentMarkItems';
        // 获取缓存中的标签项
        $items = sysvar($ckey) ?: sysvar($ckey, PluginBlogNewsMark::items());
        // 空值处理
        if (empty($mark) || $mark === ',') {
            return [];

        }
        // 去掉首尾的逗号并分割成数组
        $markArray = explode(',', trim($mark, ','));

        // 使用数组函数过滤和映射标签
        return array_values(array_filter(
            array_map(function($mark) use ($items) {
                return $items[$mark] ?? null;
            }, $markArray)
        ));
    }

    /**
     * 获取统计信息
     * @return array|mixed|null
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DbException
     */
    public static function getAuthor()
    {
        $author = ConfigService::get();
        $author['newsCount'] = PluginBlogNews::mk()->cache(true, 60)->count();
        $author['viewsCount'] = PluginBlogNews::mk()->cache(true, 60)->sum('views');
        $author['likesCount'] = PluginBlogNews::mk()->cache(true, 60)->sum('likes');
        return $author;
    }

}