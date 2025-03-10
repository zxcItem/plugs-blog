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
     * 标签处理
     * @param mixed $value
     * @return array
     */
    public function getMarkAttr($value): array
    {
        // 缓存键
        $ckey = 'PluginContentMarkItems';

        // 获取缓存中的标签项（如果没有缓存，则调用 PluginBlogMark::items() 获取并更新缓存）
        $items = sysvar($ckey);

        // 如果缓存为空，重新从数据库获取标签数据并更新缓存
        if (!$items) {
            $items = PluginBlogMark::items();
            sysvar($ckey, $items); // 更新缓存
        }

        // 去掉首尾的逗号
        $markString = trim($value, ',');

        // 将字符串按逗号分割成数组
        $markArray = explode(',', $markString);

        // 使用标签映射替换标签标识符为标签标题
        $result = [];
        foreach ($markArray as $mark) {
            if (isset($items[$mark])) {
                $result[] = $items[$mark];  // 使用标签标题替换
            }
        }

        return $result;  // 返回标签标题数组
    }
}