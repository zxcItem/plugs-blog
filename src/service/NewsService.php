<?php

declare (strict_types=1);

namespace plugin\blog\service;

use plugin\blog\model\PluginBlogAd;
use plugin\blog\model\PluginBlogBanner;
use plugin\blog\model\PluginBlogContent;
use plugin\blog\model\PluginBlogMark;
use plugin\blog\model\PluginBlogNavigation;
use plugin\blog\model\PluginBlogSeries;
use think\admin\Service;
use think\facade\Db;

/**
 * 文章
 * Class NewsService
 * @package plugin\blog\service
 */
class NewsService extends Service
{

    /**
     * 获取首页轮播图
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function banner()
    {
        return PluginBlogBanner::mk()->where('status',1)->field('title,url,cover,describe')->select()->map(function ($item){
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

    /**
     * 网页广告位
     * @param string $location
     * @param int $limit
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getAdvertisement(string $location,int $limit)
    {
        return PluginBlogAd::mk()->where(['status'=>1,'location'=>$location])->field('title,url,cover')->limit($limit)->select()->map(function ($item){
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

    /**
     * 获取首页文章列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getNewsList()
    {
        $map = [];
        if (input('series')) $map = [['series','=',input('series')]];
        if (input('mark')) $map = [['mark','like','%'.input('mark').'%']];
        $query = PluginBlogContent::mQuery()->like('title,series')->equal('code');
        $query = $query->where(['status' => 1])
            ->where($map)
            ->field('title,code,cover,describe,update_at,views,likes,mark')
            ->order(input('sort','top desc,sort desc,update_at desc'))
            ->page(true, false, false, 5);
        $query['list'] = DataService::markList($query['list']);
        return $query;
    }

    /**
     * 选择性推荐列表
     * @param string $string
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function recommendNews(string $string)
    {
        if ($string == 'views'){
            $map = ['status' => 1];$order = 'views desc,sort desc';
        }
        if ($string == 'recommend'){
            $map = ['status' => 1,'recommend'=>1];$order = 'recommend desc,views desc,sort desc';
        }
        return PluginBlogContent::mQuery()->where($map)
            ->field('title,code,cover,views')
            ->order($order)
            ->limit(6)
            ->select()->toArray();
    }

    /**
     * 获取集合详情
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getServiceNews()
    {
        return PluginBlogSeries::mk()
            ->where('sign',input('series'))
            ->withCount('news')
            ->find()->toArray();
    }

    /**
     * 获取集合列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getIndexServices()
    {
        return PluginBlogSeries::mk()
            ->where(['status'=>1,'is_show'=>1])
            ->with(['list'=>function($news){
                $news->limit(5)->field('title,code,series,update_at');
            }])
            ->withCount('news')
            ->select()->toArray();
    }

    /**
     * 获取集合内热门文章
     * @param string $series
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getSeriesNewsList(string $series)
    {
        return PluginBlogContent::mQuery()->where(['status'=>1,'series'=>$series])
            ->field('title,code,cover,views')
            ->order('views desc')
            ->limit(6)
            ->select()->toArray();
    }

    /**
     * 获取文章详情
     * @param array $map
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getNewsInfo(array $map)
    {
        $content = PluginBlogContent::mQuery()
            ->where($map)
            ->field('title, code, describe,series, views, content, mark, likes,comment, update_at')
            ->find();
        if ($content) {
            // 修改返回的内容
            $content = $content->toArray(); // 将查询结果转为数组
            $content['mark'] = DataService::markInfo($content['mark']);
            PluginBlogContent::mQuery()->where($map)->inc('views')->update();
        }
        return $content;
    }

    /**
     * 获取标签详情
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getMarkNews()
    {
        // 查询单个标签
        $mark = PluginBlogMark::mk()
            ->where('sign', input('mark'))
            ->find();
        if ($mark) {
            // 统计包含该标签的文章数量
            $mark['news_count'] = PluginBlogContent::mk()
                ->whereLike('mark', "%{$mark['sign']}%")
                ->where('status', 1)
                ->count();

            return $mark->toArray(); // 转换为数组返回
        }
        return [];
    }

    /**
     * 获取标签列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getMark()
    {
        return PluginBlogMark::mk()->where('status',1)->field('title,sign')->select()->toArray();
    }
}