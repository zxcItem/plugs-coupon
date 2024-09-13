<?php


declare (strict_types=1);

namespace plugin\coupon\controller\coupon;

use plugin\coupon\model\PluginCouponConfigCoupon;
use plugin\wemall\model\PluginWemallConfigLevel;
use think\admin\Controller;
use think\admin\helper\QueryHelper;

/**
 * 抵扣卡券管理
 * @class Config
 * @package plugin\coupon\controller\coupon
 */
class Config extends Controller
{
    /**
     * 抵扣卡券管理
     * @auth true
     * @menu true
     * @return void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->type = $this->get['type'] ?? 'index';
        PluginCouponConfigCoupon::mQuery()->layTable(function () {
            $this->title = '抵扣卡券管理';
            $this->types = PluginCouponConfigCoupon::types;
        }, function (QueryHelper $query) {
            $query->like('name')->equal('status,type#mtype')->dateBetween('create_time');
            $query->where(['deleted' => 0, 'status' => intval($this->type === 'index')]);
        });
    }

    /**
     * 添加抵扣卡券
     * @auth true
     */
    public function add()
    {
        $this->title = '添加抵扣卡券';
        PluginCouponConfigCoupon::mForm('form');
    }

    /**
     * 编辑抵扣卡券
     * @auth true
     */
    public function edit()
    {
        $this->title = '编辑抵扣卡券';
        PluginCouponConfigCoupon::mForm('form');
    }

    /**
     * 表单数据处理
     * @param array $data
     * @return void
     */
    protected function _form_filter(array &$data)
    {
        if ($this->request->isGet()) {
            $this->types = PluginCouponConfigCoupon::types;
            $this->levels = PluginWemallConfigLevel::items();
            array_unshift($this->levels, ['name' => '全部', 'number' => '-']);
        } else {
            $data['levels'] = arr2str($data['levels'] ?? []);
        }
    }

    /**
     * 表单结果处理
     * @param boolean $result
     * @return void
     */
    protected function _form_result(bool $result)
    {
        if ($result) {
            $this->success('卡券保存成功！', 'javascript:history.back()');
        } else {
            $this->error('卡券保存失败！');
        }
    }

    /**
     * 修改抵扣卡券
     * @auth true
     */
    public function state()
    {
        PluginCouponConfigCoupon::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除抵扣卡券
     * @auth true
     */
    public function remove()
    {
        PluginCouponConfigCoupon::mDelete();
    }
}