<?php

declare (strict_types=1);

namespace plugin\blog\controller\base;

use plugin\blog\model\PluginBlogSeries;
use think\admin\Controller;
use think\admin\helper\QueryHelper;


/**
 * 集合管理
 * Class Series
 * @package plugin\blog\controller\base
 */
class Series extends Controller
{

    /**
     * 集合管理
     * @return void
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        PluginBlogSeries::mQuery()->layTable(function () {
            $this->title = '集合管理';
        }, function (QueryHelper $query) {
            $query->like('title')->dateBetween('create_at');
        });
    }

    /**
     * 集合选择器
     * @login true
     * @return void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function select()
    {
        $this->get['status'] = 1;
        $this->index();
    }

    /**
     * 添加
     * @auth true
     */
    public function add()
    {
        PluginBlogSeries::mForm('form');
    }

    /**
     * 编辑
     * @auth true
     */
    public function edit()
    {
        PluginBlogSeries::mForm('form');
    }

    /**
     * 修改状态
     * @auth true
     */
    public function state()
    {
        PluginBlogSeries::mSave($this->_vali([
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
        PluginBlogSeries::mDelete();
    }
}