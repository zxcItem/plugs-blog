<?php

declare (strict_types=1);

namespace plugin\blog\controller\news;

use plugin\blog\model\PluginBlogNewsType;
use think\admin\Controller;
use think\admin\helper\QueryHelper;


/**
 * 分类管理
 * Class Type
 * @package plugin\blog\controller\news
 */
class Type extends Controller
{

    /**
     * 分类管理
     * @return void
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        PluginBlogNewsType::mQuery()->layTable(function () {
            $this->title = '分类管理';
        }, function (QueryHelper $query) {
            $query->like('title')->dateBetween('create_at');
        });
    }

    /**
     * 文章分类选择器
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
        PluginBlogNewsType::mForm('form');
    }

    /**
     * 编辑
     * @auth true
     */
    public function edit()
    {
        PluginBlogNewsType::mForm('form');
    }

    /**
     * 修改状态
     * @auth true
     */
    public function state()
    {
        PluginBlogNewsType::mSave($this->_vali([
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
        PluginBlogNewsType::mDelete();
    }
}