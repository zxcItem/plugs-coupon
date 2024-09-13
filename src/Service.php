<?php

declare (strict_types=1);

namespace plugin\coupon;

use think\admin\Plugin;

/**
 * 组件注册服务
 * @class Service
 * @package app\coupon
 */
class Service extends Plugin
{
    /**
     * 定义插件名称
     * @var string
     */
    protected $appName = '卡券管理';

    /**
     * 定义安装包名
     * @var string
     */
    protected $package = 'xiaochao/plugs-coupon';


    /**
     * 签到模块菜单配置
     * @return array[]
     */
    public static function menu(): array
    {
        // 设置插件菜单
        $code = app(static::class)->appCode;
        // 设置插件菜单
        return [
            [
                'name' => '卡券管理',
                'subs' => [
                    ['name' => '卡券配置管理', 'icon' => 'layui-icon layui-icon-set', 'node' => "{$code}/coupon.config/index"],
                    ['name' => '会员卡券管理', 'icon' => 'layui-icon layui-icon-table', 'node' => "{$code}/coupon/index"],
                ],
            ]
        ];
    }
}