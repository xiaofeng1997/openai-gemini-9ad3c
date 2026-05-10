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
use think\Response;

/**
 * 积分商城商品控制器
 * Class PointGoods
 * @package app\adminapi\controller\pointshop
 */
class PointGoods extends BaseAdminController
{
    /**
     * 商品列表
     * @return Response
     */
    public function lists()
    {
        $data = $this->request->params([
            ['keyword', ''],
            ['category_id', 0],
            ['status', ''],
        ]);
        return success((new PointGoodsService())->getPage($data));
    }

    /**
     * 商品详情
     * @param int $goods_id
     * @return Response
     */
    public function info(int $goods_id)
    {
        return success((new PointGoodsService())->getInfo($goods_id));
    }

    /**
     * 添加商品
     * @return Response
     */
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

    /**
     * 编辑商品
     * @param int $goods_id
     * @return Response
     */
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

    /**
     * 删除商品
     * @param int $goods_id
     * @return Response
     */
    public function del(int $goods_id)
    {
        (new PointGoodsService())->del($goods_id);
        return success('DELETE_SUCCESS');
    }

    /**
     * 修改商品状态
     * @return Response
     */
    public function setStatus()
    {
        $data = $this->request->params([
            ['goods_ids', []],
            ['status', 1],
        ]);
        (new PointGoodsService())->setStatus($data['goods_ids'], $data['status']);
        return success('EDIT_SUCCESS');
    }

    /**
     * 获取商品分类
     * @return Response
     */
    public function getCategory()
    {
        return success((new PointGoodsService())->getCategory());
    }
}
