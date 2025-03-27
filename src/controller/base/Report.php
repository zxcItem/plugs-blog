<?php

declare (strict_types=1);

namespace plugin\blog\controller\base;

use plugin\blog\model\PluginBlogNews;
use plugin\blog\model\PluginBlogNewsMark;
use plugin\blog\model\PluginBlogRecord;
use plugin\blog\model\PluginBlogNewsType;
use plugin\blog\service\ConfigService;
use think\admin\Controller;
use think\Model;

/**
 * 商城数据统计
 * @class Report
 * @package plugin\wemall\controller\base
 */
class Report extends Controller
{
    /**
     * 显示数据统计
     * @auth true
     * @menu true
     * @throws \think\db\exception\DbException
     */
    public function index()
    {
        $this->title = '统计数据';
        $this->data = ConfigService::get();
        $this->ContentTotal = PluginBlogNews::mk()->cache(true, 60)->count();
        $this->SeriesTotal = PluginBlogNewsType::mk()->cache(true, 60)->count();
        $this->MarkTotal = PluginBlogNewsMark::mk()->cache(true, 60)->count();
        $this->RecordTotal = PluginBlogRecord::mk()->cache(true, 60)->count();
        // 近十天的用户及交易趋势
        if (empty($this->days = $this->app->cache->get('plugin.blog.portals', []))) {
            $field = ['count(1)' => 'count', 'substr(create_at,1,10)' => 'mday'];
            // 统计文章访问数据
            $model = PluginBlogRecord::mk()->field($field);
            $records = $model->whereTime('create_at', '-10 days')->group('mday')->select()->column(null, 'mday');
            // 数据格式转换
            foreach ($records as &$record) $record = $record instanceof Model ? $record->toArray() : $record;
            // 组装15天的统计数据
            for ($i = 15; $i >= 0; $i--) {
                $date = date('Y-m-d', strtotime("-{$i}days"));
                $this->days[] = [
                    '当天日期' => date('m-d', strtotime("-{$i}days")),
                    '文章访问' => ($records[$date] ?? [])['count'] ?? 0,
                ];
            }
            $this->app->cache->set('plugin.blog.portals', $this->days, 60);
        }
        // 文章分类统计
        $levels = PluginBlogNewsType::mk()->where(['status' => 1])->column('sign code,title,0 count', 'sign');
        foreach (PluginBlogNews::mk()->field('count(1) count,type')->group('type')->cursor() as $vo) {
            $levels[$vo['type']]['count'] = isset($levels[$vo['type']]) ? $vo['count'] : 0;
        }
        $this->levels = array_values($levels);
        $this->fetch();
    }
}