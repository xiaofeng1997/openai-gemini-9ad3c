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

namespace app\service\admin\pointshop;

use app\model\pointshop\PointGoods;
use core\base\BaseAdminService;
use core\exception\AdminException;

/**
 * 积分商品服务层
 * Class PointGoodsService
 * @package app\service\admin\pointshop
 */
class PointGoodsService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new PointGoods();
    }

    /**
     * 商品分页列表
     * @param array $where
     * @return array
     */
    public function getPage(array $where = [])
    {
        $field = 'goods_id, category_id, goods_name, goods_image, goods_images, point_price, price, stock, sales_num, limit_num, exchange_desc, goods_content, sort, status, create_time, update_time';
        $searchModel = $this->model->withSearch(['keyword', 'category_id', 'status'], $where)
            ->field($field)
            ->order('sort desc, goods_id desc')
            ->append(['status_name']);
        return $this->pageQuery($searchModel);
    }

    /**
     * 商品详情
     * @param int $goods_id
     * @return array
     */
    public function getInfo(int $goods_id)
    {
        return $this->model->where(['goods_id' => $goods_id])->findOrEmpty()->toArray();
    }

    /**
     * 添加商品
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        $data['create_time'] = time();
        $data['update_time'] = time();
        $result = $this->model->create($data);
        return $result->goods_id;
    }

    /**
     * 编辑商品
     * @param int $goods_id
     * @param array $data
     * @return true
     */
    public function edit(int $goods_id, array $data)
    {
        $data['update_time'] = time();
        $this->model->where(['goods_id' => $goods_id])->update($data);
        return true;
    }

    /**
     * 删除商品
     * @param int $goods_id
     * @return true
     */
    public function del(int $goods_id)
    {
        $goods = $this->model->find($goods_id);
        if (empty($goods)) {
            throw new AdminException('GOODS_NOT_EXIST');
        }
        $this->model->destroy($goods_id);
        return true;
    }

    /**
     * 设置商品状态
     * @param array $goods_ids
     * @param int $status
     * @return true
     */
    public function setStatus(array $goods_ids, int $status)
    {
        $this->model->whereIn('goods_id', $goods_ids)->update(['status' => $status, 'update_time' => time()]);
        return true;
    }

    /**
     * 获取商品分类列表
     * @return array
     */
    public function getCategory()
    {
        $categoryService = new PointCategoryService();
        return $categoryService->getList();
    }
}
