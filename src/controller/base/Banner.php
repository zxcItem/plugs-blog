<?php

declare (strict_types=1);

namespace plugin\blog\controller\base;

use plugin\blog\model\PluginBlogBanner;
use plugin\blog\service\ConfigService;
use think\admin\Controller;
use think\admin\helper\QueryHelper;


/**
 * 首页轮播
 * Class Banner
 * @package plugin\blog\controller\base
 */
class Banner extends Controller
{

    /**
     * 首页轮播
     * @return void
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        PluginBlogBanner::mQuery()->layTable(function () {
            $this->title = '首页轮播';
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
        PluginBlogBanner::mForm('form');
    }

    /**
     * 编辑
     * @auth true
     */
    public function edit()
    {
        PluginBlogBanner::mForm('form');
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
        $this->rules = ConfigService::rules;
    }

    /**
     * 修改状态
     * @auth true
     */
    public function state()
    {
        PluginBlogBanner::mSave($this->_vali([
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
        PluginBlogBanner::mDelete();
    }
}