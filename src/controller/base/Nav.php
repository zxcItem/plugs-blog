<?php

declare (strict_types=1);

namespace plugin\blog\controller\base;

use plugin\blog\model\PluginBlogNavigation;
use think\admin\Controller;
use think\admin\helper\QueryHelper;


/**
 * 首页导航
 * Class Nav
 * @package plugin\blog\controller\base
 */
class Nav extends Controller
{
    /**
     * 跳转规则定义
     * @var string[]
     */
    protected $rules = [
        '/'  => ['name' => '不跳转'],
        'LK' => ['name' => '自定义链接'],
        'JH' => ['name' => '集合详情页','node' => 'plugin-blog/base.series/select'],
        'WZ' => ['name' => '文章详情页', 'node' => 'plugin-blog/content.item/select'],
    ];


    /**
     * 首页导航
     * @return void
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        PluginBlogNavigation::mQuery()->layTable(function () {
            $this->title = '首页导航';
        }, function (QueryHelper $query) {
            $query->like('title')->dateBetween('create_at');
        });
    }

    /**
     * 添加
     * @auth true
     */
    public function add()
    {
        PluginBlogNavigation::mForm('form');
    }

    /**
     * 编辑
     * @auth true
     */
    public function edit()
    {
        PluginBlogNavigation::mForm('form');
    }

    /**
     * 修改状态
     * @auth true
     */
    public function state()
    {
        PluginBlogNavigation::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除
     * @auth true
     */
    public function remove()
    {
        PluginBlogNavigation::mDelete();
    }
}