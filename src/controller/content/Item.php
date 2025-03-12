<?php

declare (strict_types=1);

namespace plugin\blog\controller\content;

use plugin\blog\model\PluginBlogContent;
use plugin\blog\model\PluginBlogMark;
use plugin\blog\model\PluginBlogSeries;
use think\admin\Controller;
use think\admin\extend\CodeExtend;
use think\admin\helper\QueryHelper;


/**
 * 文章内容管理
 * Class Item
 * @package plugin\blog\controller\base
 */
class Item extends Controller
{

    /**
     * 文章内容管理
     * @return void
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        PluginBlogContent::mQuery()->layTable(function () {
            $this->title = '文章内容管理';
        }, function (QueryHelper $query) {
            $query->like('title,code')->dateBetween('create_at');
        });
    }

    /**
     * 文章选择器
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
        $this->title = '添加文章内容';
        PluginBlogContent::mForm('form');
    }

    /**
     * 编辑
     * @auth true
     */
    public function edit()
    {
        $this->title = '编辑文章内容';
        PluginBlogContent::mForm('form');
    }

    /**
     * 表单数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _form_filter(array &$data)
    {
        if (empty($data['code'])) {
            $data['code'] = CodeExtend::uniqidNumber(10, 'A');
        }
        if ($this->request->isGet()) {
            $model = PluginBlogMark::mk()->where(['status' => 1]);
            $this->marks = $model->order('sort desc,id desc')->select()->toArray();
            $this->serice = PluginBlogSeries::get();
            $data['mark'] = str2arr($data['mark'] ?? '');
        } else {
            $data['mark'] = arr2str($data['mark'] ?? []);
            if (empty($data['views'])) $data['views'] = $data['virtual_view'];
            if (empty($data['likes'])) $data['likes'] = $data['virtual_like'];
        }
    }

    /**
     * 表单结果处理
     * @param boolean $state
     */
    protected function _form_result(bool $state)
    {
        if ($state) {
            $this->success('文章保存成功！', 'javascript:history.back()');
        }
    }

    /**
     * 修改状态
     * @auth true
     */
    public function state()
    {
        PluginBlogContent::mSave($this->_vali([
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
        PluginBlogContent::mDelete();
    }
}