<?php

declare (strict_types=1);

namespace plugin\coupon\model;

use plugin\account\model\Abs;
use think\model\relation\HasMany;

/**
 * 商城卡券模型
 * @class PluginCouponConfigCoupon
 * @package plugin\coupon\model
 */
class PluginCouponConfigCoupon extends Abs
{
    // 卡券类型
    public const types = ['通用券', '商品券'];

    /**
     * 关联自己的卡券
     * @return \think\model\relation\HasMany
     */
    public function usable(): HasMany
    {
        return $this->hasMany(PluginCouponUserCoupon::class, 'coid', 'id')->where(['deleted' => 0]);
    }

    /**
     * 获取等级限制
     * @param mixed $value
     * @return array
     */
    public function getLimitLevelsAttr($value): array
    {
        return is_string($value) ? str2arr($value) : [];
    }

    /**
     * 设置等级限制
     * @param mixed $value
     * @return string
     */
    public function setLimitLevelsAttr($value): string
    {
        return is_array($value) ? arr2str($value) : $value;
    }

    /**
     * 输出格式化数据
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();
        if (isset($data['type'])) {
            $data['type_name'] = self::types[$data['type']] ?? $data['type'];
        }
        return $data;
    }
}