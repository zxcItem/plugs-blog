<?php

use think\admin\extend\PhinxExtend;
use think\migration\Migrator;

class InstallBlog extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->_create_plugin_blog_ad();
        $this->_create_plugin_blog_banner();
        $this->_create_plugin_blog_record();
        $this->_create_plugin_blog_news();
        $this->_create_plugin_blog_news_mark();
        $this->_create_plugin_blog_news_type();
        $this->_create_plugin_blog_navigation();
        $this->_create_plugin_blog_news_comment();
    }

    /**
     * 标签信息
     * @class PluginBlogNewsMark
     * @table plugin_blog_news_mark
     * @return void
     */
    private function _create_plugin_blog_news_mark()
    {
        // 创建数据表对象
        $table = $this->table('plugin_blog_news_mark', [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '标签信息',
        ]);
        PhinxExtend::upgrade($table, [
            ['cover', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '标签封面']],
            ['title', 'string', ['limit' => 32,'default' => null, 'null' => true, 'comment' => '标签名称']],
            ['sign', 'string', ['limit' => 32,'default' => NULL, 'null' => true, 'comment' => '标签标识']],
            ['describe', 'string', ['limit' => 255,'default' => NULL, 'null' => true, 'comment' => '描述']],
            ['sort', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '排序权重']],
            ['status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '状态']],
            ['create_at', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '创建时间']],
        ], [
            'sign','sort','status'
        ], true);
    }

    /**
     * 文章分类
     * @class PluginBlogNewsType
     * @table plugin_blog_news_type
     * @return void
     */
    private function _create_plugin_blog_news_type()
    {
        // 创建数据表对象
        $table = $this->table('plugin_blog_news_type', [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '文章分类',
        ]);
        PhinxExtend::upgrade($table, [
            ['cover', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '分类封面']],
            ['title', 'string', ['limit' => 32,'default' => null, 'null' => true, 'comment' => '分类标题']],
            ['sign', 'string', ['limit' => 32,'default' => NULL, 'null' => true, 'comment' => '分类标识']],
            ['describe', 'string', ['limit' => 255,'default' => NULL, 'null' => true, 'comment' => '描述']],
            ['is_show', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '首页展示']],
            ['sort', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '排序权重']],
            ['status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '状态']],
            ['create_at', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '创建时间']],
        ], [
            'sign','sort','status'
        ], true);
    }

    /**
     * 导航信息
     * @class PluginBlogNavigation
     * @table plugin_blog_navigation
     * @return void
     */
    private function _create_plugin_blog_navigation()
    {
        // 创建数据表对象
        $table = $this->table('plugin_blog_navigation', [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '导航信息',
        ]);
        PhinxExtend::upgrade($table, [
            ['title', 'string', ['limit' => 32,'default' => null, 'null' => true, 'comment' => '导航名称']],
            ['url', 'string', ['limit' => 255,'default' => NULL, 'null' => true, 'comment' => '导航链接']],
            ['sort', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '排序权重']],
            ['status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '状态']],
            ['create_at', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '创建时间']],
        ], [
            'sort','status'
        ], true);
    }

    /**
     * 轮播信息
     * @class PluginBlogBanner
     * @table plugin_blog_banner
     * @return void
     */
    private function _create_plugin_blog_banner()
    {
        // 创建数据表对象
        $table = $this->table('plugin_blog_banner', [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '轮播信息',
        ]);
        PhinxExtend::upgrade($table, [
            ['cover', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '封面']],
            ['title', 'string', ['limit' => 64,'default' => null, 'null' => true, 'comment' => '标题']],
            ['describe', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '描述']],
            ['url', 'string', ['limit' => 255,'default' => NULL, 'null' => true, 'comment' => '跳转链接']],
            ['sort', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '排序权重']],
            ['status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '状态']],
            ['create_at', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '创建时间']],
        ], [
            'sort','status'
        ], true);
    }

    /**
     * 广告位
     * @class PluginBlogAd
     * @table plugin_blog_ad
     * @return void
     */
    private function _create_plugin_blog_ad()
    {
        // 创建数据表对象
        $table = $this->table('plugin_blog_ad', [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '广告位',
        ]);
        PhinxExtend::upgrade($table, [
            ['cover', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '封面']],
            ['title', 'string', ['limit' => 64,'default' => null, 'null' => true, 'comment' => '标题']],
            ['location', 'string', ['limit' => 64,'default' => null, 'null' => true, 'comment' => '位置']],
            ['describe', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '描述']],
            ['url', 'string', ['limit' => 255,'default' => NULL, 'null' => true, 'comment' => '跳转链接']],
            ['sort', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '排序权重']],
            ['status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '状态']],
            ['create_at', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '创建时间']],
        ], [
            'sort','status'
        ], true);
    }

    /**
     * 文章内容
     * @class PluginBlogNews
     * @table plugin_blog_news
     * @return void
     */
    private function _create_plugin_blog_news()
    {
        // 创建数据表对象
        $table = $this->table('plugin_blog_news', [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '文章内容',
        ]);
        PhinxExtend::upgrade($table, [
            ['cover', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '封面']],
            ['title', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '标题']],
            ['describe', 'string', ['limit' => 255,'default' => NULL, 'null' => true, 'comment' => '描述']],
            ['keywords', 'string', ['limit' => 255,'default' => NULL, 'null' => true, 'comment' => '关键字']],
            ['code', 'string', ['limit' => 32,'default' => null, 'null' => true, 'comment' => '编号']],
            ['content', 'text', ['default' => NULL, 'null' => true, 'comment' => '内容']],
            ['type', 'string', ['limit' => 32,'default' => NULL, 'null' => true, 'comment' => '所属集合']],
            ['mark', 'string', ['limit' => 255,'default' => NULL, 'null' => true, 'comment' => '标签']],
            ['views', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '浏览量']],
            ['virtual_view', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '虚拟浏览量']],
            ['likes', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '点赞量']],
            ['virtual_like', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '虚拟点赞量']],
            ['comment_sum', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '评论量']],
            ['recommend', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '推荐']],
            ['top', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '置顶']],
            ['comment', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '评论状态']],
            ['sort', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '排序权重']],
            ['status', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '状态']],
            ['update_at', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '更新时间']],
            ['create_at', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '创建时间']],
        ], [
            'type','mark','views','likes','recommend','top','comment','sort','status','update_at'
        ], true);
    }

    /**
     * 文章访问记录
     * @class PluginBlogRecord
     * @table plugin_blog_record
     * @return void
     */
    private function _create_plugin_blog_record()
    {
        // 创建数据表对象
        $table = $this->table('plugin_blog_record', [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '广告位',
        ]);
        PhinxExtend::upgrade($table, [
            ['ip', 'string', ['limit' => 64,'default' => null, 'null' => true, 'comment' => 'IP地址']],
            ['type', 'string', ['limit' => 32,'default' => 'view', 'null' => true, 'comment' => '类型：view(浏览),like(点赞)']],
            ['code', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '文章编号']],
            ['create_at', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '创建时间']],
        ], [
            'ip','create_at'
        ], true);
    }

    /**
     * 文章评论记录
     * @class PluginBlogNewsComment
     * @table plugin_blog_news_comment
     * @return void
     */
    private function _create_plugin_blog_news_comment()
    {
        // 创建数据表对象
        $table = $this->table('plugin_blog_news_comment', [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '文章评论记录',
        ]);
        PhinxExtend::upgrade($table, [
            ['uuid', 'string', ['limit' => 64,'default' => null, 'null' => true, 'comment' => '用户ID']],
            ['ip', 'string', ['limit' => 64,'default' => null, 'null' => true, 'comment' => 'IP地址']],
            ['code', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '文章编号']],
            ['nickname', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '昵称']],
            ['email', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '邮箱']],
            ['content', 'string', ['limit' => 500,'default' => null, 'null' => true, 'comment' => '内容']],
            ['status', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '状态']],
            ['create_at', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '创建时间']],
        ], [
            'uuid','ip','code','create_at'
        ], true);
    }
}
