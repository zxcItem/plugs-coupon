<?php

use think\migration\Migrator;

class InstallCoupon extends Migrator
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
        $this->_create_plugin_coupon_config_coupon();
        $this->_create_plugin_coupon_user_coupon();
    }

    /**
     * 商城-配置-卡券
     * @class PluginCouponConfigCoupon
     * @table plugin_coupon_config_coupon
     * @return void
     */
    private function _create_plugin_coupon_config_coupon()
    {

        // 当前数据表
        $table = 'plugin_coupon_config_coupon';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-配置-卡券',
        ])
            ->addColumn('type', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '类型(0通用券,1商品券)'])
            ->addColumn('name', 'string', ['limit' => 200, 'default' => '', 'null' => true, 'comment' => '优惠名称'])
            ->addColumn('cover', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '封面图标'])
            ->addColumn('extra', 'text', ['default' => NULL, 'null' => true, 'comment' => '扩展数据'])
            ->addColumn('content', 'text', ['default' => NULL, 'null' => true, 'comment' => '内容描述'])
            ->addColumn('remark', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '系统备注'])
            ->addColumn('amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '抵扣金额'])
            ->addColumn('limit_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '金额门槛(0不限制)'])
            ->addColumn('limit_levels', 'string', ['limit' => 180, 'default' => '-', 'null' => true, 'comment' => '授权等级'])
            ->addColumn('limit_times', 'biginteger', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '限领数量(0不限制)'])
            ->addColumn('expire_days', 'biginteger', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '有效天数'])
            ->addColumn('total_stock', 'biginteger', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '库存数量'])
            ->addColumn('total_sales', 'biginteger', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '发放数量'])
            ->addColumn('total_used', 'biginteger', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '使用数量'])
            ->addColumn('sort', 'biginteger', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '卡券状态(0禁用,1使用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态(1已删,0未删)'])
            ->addColumn('create_time', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '更新时间'])
            ->addIndex('sort', ['name' => 'ibfe2b6128_sort'])
            ->addIndex('type', ['name' => 'ibfe2b6128_type'])
            ->addIndex('status', ['name' => 'ibfe2b6128_status'])
            ->addIndex('deleted', ['name' => 'ibfe2b6128_deleted'])
            ->addIndex('create_time', ['name' => 'ibfe2b6128_create_time'])
            ->create();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 11, 'identity' => true]);
    }

    /**
     * 商城-用户-卡券
     * @class PluginCouponUserCoupon
     * @table plugin_coupon_user_coupon
     * @return void
     */
    private function _create_plugin_coupon_user_coupon()
    {

        // 当前数据表
        $table = 'plugin_coupon_user_coupon';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-用户-卡券',
        ])
            ->addColumn('type', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '卡券类型'])
            ->addColumn('unid', 'biginteger', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '用户UNID'])
            ->addColumn('coid', 'biginteger', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '配置编号'])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '卡券编号'])
            ->addColumn('used', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '使用状态'])
            ->addColumn('used_time', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '使用时间'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '生效状态(0未生效,1待使用,2已使用,3已过期)'])
            ->addColumn('status_desc', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '状态描述'])
            ->addColumn('status_time', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '修改时间'])
            ->addColumn('expire', 'biginteger', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '有效时间'])
            ->addColumn('expire_time', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '有效日期'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态(0未删除,1已删除)'])
            ->addColumn('create_time', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '更新时间'])
            ->addColumn('confirm_time', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '到账时间'])
            ->addIndex('code', ['name' => 'ic31512dc2_code'])
            ->addIndex('unid', ['name' => 'ic31512dc2_unid'])
            ->addIndex('coid', ['name' => 'ic31512dc2_coid'])
            ->addIndex('used', ['name' => 'ic31512dc2_used'])
            ->addIndex('status', ['name' => 'ic31512dc2_status'])
            ->addIndex('expire', ['name' => 'ic31512dc2_expire'])
            ->addIndex('deleted', ['name' => 'ic31512dc2_deleted'])
            ->addIndex('create_time', ['name' => 'ic31512dc2_create_time'])
            ->addIndex('confirm_time', ['name' => 'ic31512dc2_confirm_time'])
            ->create();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 11, 'identity' => true]);
    }
}
