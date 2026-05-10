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
        'goods_name.require' => '商品名称不能为空',
        'goods_name.max' => '商品名称最多200个字符',
        'category_id.require' => '请选择商品分类',
        'goods_image.require' => '请上传商品图片',
        'point_price.require' => '积分价格不能为空',
        'point_price.number' => '积分价格必须为数字',
        'point_price.egt' => '积分价格不能小于0',
        'price.require' => '市场价格不能为空',
        'price.number' => '市场价格必须为数字',
        'price.egt' => '市场价格不能小于0',
        'stock.require' => '库存不能为空',
        'stock.number' => '库存必须为数字',
        'stock.egt' => '库存不能小于0',
        'limit_num.number' => '限购数量必须为数字',
        'limit_num.egt' => '限购数量不能小于0',
        'sort.number' => '排序必须为数字',
        'sort.egt' => '排序不能小于0',
        'status.require' => '状态不能为空',
        'status.in' => '状态值不正确',
    ];

    protected $scene = [
        'add' => ['goods_name', 'category_id', 'goods_image', 'point_price', 'price', 'stock'],
        'edit' => ['goods_name', 'category_id', 'goods_image', 'point_price', 'price', 'stock'],
    ];
}
