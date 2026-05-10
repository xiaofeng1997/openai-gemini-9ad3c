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

namespace app\adminapi\controller\pointshop;

use app\service\admin\pointshop\PointGoodsService;
use core\base\BaseAdminController;

class PointGoods extends BaseAdminController
{
    public function lists()
    {
        $data = $this->request->params([
            ['keyword', ''],
            ['category_id', 0],
            ['status', ''],
        ]);
        return success((new PointGoodsService())->getPage($data));
    }

    public function info(int $goods_id)
    {
        return success((new PointGoodsService())->getInfo($goods_id));
    }

    public function add()
    {
        $data = $this->request->params([
            ['goods_name', ''],
            ['category_id', 0],
            ['goods_image', ''],
            ['goods_images', []],
            ['point_price', 0],
            ['price', 0],
            ['stock', 0],
            ['sales_num', 0],
            ['limit_num', 0],
            ['exchange_desc', ''],
            ['goods_content', ''],
            ['sort', 0],
            ['status', 1],
        ]);
        $this->validate($data, 'app\validate\pointshop\PointGoods.add');
        $res = (new PointGoodsService())->add($data);
        return success('ADD_SUCCESS', ['goods_id' => $res]);
    }

    public function edit(int $goods_id)
    {
        $data = $this->request->params([
            ['goods_name', ''],
            ['category_id', 0],
            ['goods_image', ''],
            ['goods_images', []],
            ['point_price', 0],
            ['price', 0],
            ['stock', 0],
            ['sales_num', 0],
            ['limit_num', 0],
            ['exchange_desc', ''],
            ['goods_content', ''],
            ['sort', 0],
            ['status', 1],
        ]);
        $this->validate($data, 'app\validate\pointshop\PointGoods.edit');
        (new PointGoodsService())->edit($goods_id, $data);
        return success('EDIT_SUCCESS');
    }

    public function del(int $goods_id)
    {
        (new PointGoodsService())->del($goods_id);
        return success('DELETE_SUCCESS');
    }

    public function setStatus()
    {
        $data = $this->request->params([
            ['goods_ids', []],
            ['status', 1],
        ]);
        (new PointGoodsService())->setStatus($data['goods_ids'], $data['status']);
        return success('EDIT_SUCCESS');
    }

    public function getCategory()
    {
        return success((new PointGoodsService())->getCategory());
    }
}
