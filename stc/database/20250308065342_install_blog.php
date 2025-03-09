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
        $this->_create_plugin_blog_mark();
        $this->_create_plugin_blog_series();
        $this->_create_plugin_blog_content();
        $this->_create_plugin_blog_navigation();
    }

    /**
     * 标签信息
     * @class PluginBlogMark
     * @table plugin_blog_mark
     * @return void
     */
    private function _create_plugin_blog_mark()
    {
        // 创建数据表对象
        $table = $this->table('plugin_blog_mark', [
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
     * 集合信息
     * @class PluginBlogSeries
     * @table plugin_blog_series
     * @return void
     */
    private function _create_plugin_blog_series()
    {
        // 创建数据表对象
        $table = $this->table('plugin_blog_series', [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '集合信息',
        ]);
        PhinxExtend::upgrade($table, [
            ['cover', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '集合封面']],
            ['title', 'string', ['limit' => 32,'default' => null, 'null' => true, 'comment' => '集合名称']],
            ['sign', 'string', ['limit' => 32,'default' => NULL, 'null' => true, 'comment' => '集合标识']],
            ['describe', 'string', ['limit' => 255,'default' => NULL, 'null' => true, 'comment' => '描述']],
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
     * 内容信息
     * @class PluginBlogContent
     * @table plugin_blog_content
     * @return void
     */
    private function _create_plugin_blog_content()
    {
        // 创建数据表对象
        $table = $this->table('plugin_blog_content', [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '内容信息',
        ]);
        PhinxExtend::upgrade($table, [
            ['cover', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '封面']],
            ['title', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '标题']],
            ['describe', 'string', ['limit' => 255,'default' => NULL, 'null' => true, 'comment' => '描述']],
            ['code', 'string', ['limit' => 32,'default' => null, 'null' => true, 'comment' => '编号']],
            ['content', 'text', ['default' => NULL, 'null' => true, 'comment' => '内容']],
            ['series', 'string', ['limit' => 32,'default' => NULL, 'null' => true, 'comment' => '所属集合']],
            ['mark', 'string', ['limit' => 255,'default' => NULL, 'null' => true, 'comment' => '标签']],
            ['views', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '浏览量']],
            ['virtual_view', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '虚拟浏览量']],
            ['likes', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '点赞量']],
            ['virtual_like', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '虚拟点赞量']],
            ['recommend', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '推荐']],
            ['sort', 'biginteger', ['default' => 0, 'null' => true, 'comment' => '排序权重']],
            ['status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '状态']],
            ['update_at', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '更新时间']],
            ['create_at', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '创建时间']],
        ], [
            'series','mark','views','virtual_view','likes','virtual_like','sort','status','update_at'
        ], true);
    }
}
