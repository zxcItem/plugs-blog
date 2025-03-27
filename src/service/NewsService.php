<?php

declare (strict_types=1);

namespace plugin\blog\service;

use plugin\blog\model\PluginBlogAd;
use plugin\blog\model\PluginBlogBanner;
use plugin\blog\model\PluginBlogNews;
use plugin\blog\model\PluginBlogNewsMark;
use plugin\blog\model\PluginBlogNavigation;
use plugin\blog\model\PluginBlogNewsComment;
use plugin\blog\model\PluginBlogRecord;
use plugin\blog\model\PluginBlogNewsType;
use think\admin\Service;

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
        if (input('type')) $map = [['type','=',input('type')]];
        if (input('mark')) $map = [['mark','like','%'.input('mark').'%']];
        $query = PluginBlogNews::mQuery()->where(['status' => 1])
            ->where($map);
        $query = $query->like('title#keyword,type')->equal('code')
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
        return PluginBlogNews::mQuery()->where($map)
            ->field('title,code,cover,views')
            ->order($order)
            ->limit(6)
            ->select()->toArray();
    }

    /**
     * 获取分类详情
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getServiceNews()
    {
        return PluginBlogNewsType::mk()
            ->where('sign',input('type'))
            ->withCount('news')
            ->find()->toArray();
    }

    /**
     * 获取分类列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getIndexTypes()
    {
        return PluginBlogNewsType::mk()
            ->where(['status'=>1,'is_show'=>1])
            ->with(['list'=>function($news){
                $news->limit(5)->field('title,code,type,update_at');
            }])
            ->withCount('news')
            ->select()->toArray();
    }

    /**
     * 获取分类内热门文章
     * @param string $type
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getTypesNewsList(string $type)
    {
        return PluginBlogNews::mQuery()->where(['status'=>1,'type'=>$type])
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
        $content = PluginBlogNews::mQuery()
            ->where($map)
            ->field('title,cover,code, describe,keywords,type, views, content, mark, likes,comment, update_at')
            ->find();
        if ($content) {
            // 修改返回的内容
            $content = $content->toArray(); // 将查询结果转为数组
            $content['mark'] = DataService::markInfo($content['mark']);
            PluginBlogNews::mQuery()->where($map)->inc('views')->update();
            PluginBlogRecord::mk()->save(['ip'=>$_SERVER['REMOTE_ADDR'],'user_agent'=>$_SERVER['HTTP_USER_AGENT'],'code'=>$map['code']]);
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
        $mark = PluginBlogNewsMark::mk()
            ->where('sign', input('mark'))
            ->find();
        if ($mark) {
            // 统计包含该标签的文章数量
            $mark['news_count'] = PluginBlogNews::mk()
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
        return PluginBlogNewsMark::mk()->where('status',1)->field('title,sign')->select()->toArray();
    }

    /**
     * 文章点赞
     * @param array $map
     * @return array|mixed|\think\admin\helper\QueryHelper|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function like(array $map)
    {
        $content = PluginBlogNews::mQuery()
            ->where($map)
            ->find();
        if (!$content) return false;
        PluginBlogNews::mQuery()->where($map)->inc('likes')->update();
        PluginBlogRecord::mk()->save(['ip'=>$_SERVER['REMOTE_ADDR'],'user_agent'=>$_SERVER['HTTP_USER_AGENT'],'code'=>$map['code'],'type'=>'like']);
        return true;
    }

    /**
     * 文章提交评论
     * @param array $map
     * @return bool
     */
    public static function comment(array $map)
    {
        $map['ip'] = $_SERVER['REMOTE_ADDR'];
        return PluginBlogNewsComment::mk()->save($map);
    }
}