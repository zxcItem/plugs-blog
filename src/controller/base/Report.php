<?php

declare (strict_types=1);

namespace plugin\blog\controller\base;

use plugin\blog\model\PluginBlogContent;
use plugin\blog\model\PluginBlogMark;
use plugin\blog\model\PluginBlogRecord;
use plugin\blog\model\PluginBlogSeries;
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
        $this->ContentTotal = PluginBlogContent::mk()->cache(true, 60)->count();
        $this->SeriesTotal = PluginBlogSeries::mk()->cache(true, 60)->count();
        $this->MarkTotal = PluginBlogMark::mk()->cache(true, 60)->count();
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
        // 会员级别分布统计
        $levels = PluginBlogSeries::mk()->where(['status' => 1])->column('sign code,title,0 count', 'sign');
        foreach (PluginBlogContent::mk()->field('count(1) count,series')->group('series')->cursor() as $vo) {
            $levels[$vo['series']]['count'] = isset($levels[$vo['series']]) ? $vo['count'] : 0;
        }
        $this->levels = array_values($levels);
        $this->fetch();
    }
}