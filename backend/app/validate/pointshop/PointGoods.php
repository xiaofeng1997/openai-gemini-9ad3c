<?php
// +----------------------------------------------------------------------
// | Niucloud-Lite-Ai 企业快速开发的管理平台
// +----------------------------------------------------------------------
// | 官方网址：https://www.niucloud.com
// +----------------------------------------------------------------------
// | niucloud团队 版权所有 开源版本可自由商用
// +----------------------------------------------------------------------
// | Author: Niucloud Team
// +----------------------------------------------------------------------

namespace app\validate\pointshop;

use think\Validate;

class PointGoods extends Validate
{
    protected $rule = [
        'goods_name' => 'require|max:200',
        'category_id' => 'require|number',
        'goods_image' => 'require',
        'point_price' => 'require|number|egt:0',
        'price' => 'require|number|egt:0',
        'stock' => 'require|number|egt:0',
        'limit_num' => 'number|egt:0',
        'sort' => 'number|egt:0',
        'status' => 'require|number|in:0,1',
    ];

    protected $message = [
        'goods_name.require' => 'goods_name_require',
        'goods_name.max' => 'goods_name_max',
        'category_id.require' => 'category_id_require',
        'goods_image.require' => 'goods_image_require',
        'point_price.require' => 'point_price_require',
        'point_price.number' => 'point_price_number',
        'point_price.egt' => 'point_price_egt',
        'price.require' => 'price_require',
        'price.number' => 'price_number',
        'price.egt' => 'price_egt',
        'stock.require' => 'stock_require',
        'stock.number' => 'stock_number',
        'stock.egt' => 'stock_egt',
        'limit_num.number' => 'limit_num_number',
        'limit_num.egt' => 'limit_num_egt',
        'sort.number' => 'sort_number',
        'sort.egt' => 'sort_egt',
        'status.require' => 'status_require',
        'status.in' => 'status_in',
    ];

    protected $scene = [
        'add' => ['goods_name', 'category_id', 'goods_image', 'point_price', 'price', 'stock'],
        'edit' => ['goods_name', 'category_id', 'goods_image', 'point_price', 'price', 'stock'],
    ];
}
