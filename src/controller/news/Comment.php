<?php

declare (strict_types=1);

namespace plugin\blog\controller\news;

use plugin\blog\model\PluginBlogNewsComment;
use think\admin\Controller;
use think\admin\helper\QueryHelper;


/**
 * 文章评论记录
 * Class Comment
 * @package plugin\blog\controller\news
 */
class Comment extends Controller
{

    /**
     * 文章评论记录
     * @return void
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        PluginBlogNewsComment::mQuery()->layTable(function () {
            $this->title = '文章评论记录';
        }, function (QueryHelper $query) {
            $query->with(['newsTitle'])->like('nickname,email,content,code')->dateBetween('create_at');
        });
    }

    /**
     * 编辑
     * @auth true
     */
    public function edit()
    {
        PluginBlogNewsComment::mForm('form');
    }

    /**
     * 修改状态
     * @auth true
     */
    public function state()
    {
        PluginBlogNewsComment::mSave($this->_vali([
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
        PluginBlogNewsComment::mDelete();
    }
}