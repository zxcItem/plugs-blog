<?php

declare (strict_types=1);

namespace plugin\blog\controller\base;

use plugin\blog\model\PluginBlogMark;
use think\admin\Controller;
use think\admin\helper\QueryHelper;


/**
 * 标签云管理
 * Class Mark
 * @package plugin\blog\controller\base
 */
class Mark extends Controller
{

    /**
     * 标签云管理
     * @return void
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        PluginBlogMark::mQuery()->layTable(function () {
            $this->title = '标签云管理';
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
        PluginBlogMark::mForm('form');
    }

    /**
     * 编辑
     * @auth true
     */
    public function edit()
    {
        PluginBlogMark::mForm('form');
    }

    /**
     * 修改状态
     * @auth true
     */
    public function state()
    {
        PluginBlogMark::mSave($this->_vali([
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
        PluginBlogMark::mDelete();
    }
}