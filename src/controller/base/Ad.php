<?php

declare (strict_types=1);

namespace plugin\blog\controller\base;

use plugin\blog\model\PluginBlogAd;
use plugin\blog\service\ConfigService;
use think\admin\Controller;
use think\admin\helper\QueryHelper;


/**
 * 广告位
 * Class Ad
 * @package plugin\blog\controller\base
 */
class Ad extends Controller
{

    /**
     * 广告位
     * @return void
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        PluginBlogAd::mQuery()->layTable(function () {
            $this->title = '广告位';
        }, function (QueryHelper $query) {
            $query->like('title')->dateBetween('create_at');
        });
    }

    /**
     * 列表数据处理
     * @param array $data
     * @throws \Exception
     */
    protected function _index_page_filter(array &$data)
    {
        foreach ($data as &$datum) $datum['location'] = ConfigService::location[$datum['location']];
    }

    /**
     * 添加
     * @auth true
     */
    public function add()
    {
        PluginBlogAd::mForm('form');
    }

    /**
     * 编辑
     * @auth true
     */
    public function edit()
    {
        PluginBlogAd::mForm('form');
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
        $this->location = ConfigService::location;
    }

    /**
     * 修改状态
     * @auth true
     */
    public function state()
    {
        PluginBlogAd::mSave($this->_vali([
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
        PluginBlogAd::mDelete();
    }
}