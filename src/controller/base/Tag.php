<?php

declare (strict_types=1);

namespace plugin\blog\controller\base;

use plugin\blog\model\PluginBlogTag;
use think\admin\Controller;
use think\admin\helper\QueryHelper;


/**
 * 标签云管理
 * Class Tag
 * @package plugin\blog\controller\base
 */
class Tag extends Controller
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
        PluginBlogTag::mQuery()->layTable(function () {
            $this->title = '标签云管理';
        }, function (QueryHelper $query) {
            $query->dateBetween('create_at');
        });
    }

    /**
     * 添加
     * @auth true
     */
    public function add()
    {
        PluginBlogTag::mForm('form');
    }

    /**
     * 编辑
     * @auth true
     */
    public function edit()
    {
        PluginBlogTag::mForm('form');
    }

    /**
     * 修改状态
     * @auth true
     */
    public function state()
    {
        PluginBlogTag::mSave($this->_vali([
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
        PluginBlogTag::mDelete();
    }
}