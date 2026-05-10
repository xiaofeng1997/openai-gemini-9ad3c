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

class PointGoodsService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new PointGoods();
    }

    public function getPage(array $where = [])
    {
        $field = 'goods_id, category_id, goods_name, goods_image, point_price, price, stock, sales_num, limit_num, sort, status, create_time, update_time';
        $searchModel = $this->model->withSearch(['keyword', 'category_id', 'status'], $where)
            ->with(['category'])
            ->field($field)
            ->order('sort desc, goods_id desc')
            ->append(['status_name']);
        return $this->pageQuery($searchModel);
    }

    public function getInfo(int $goods_id)
    {
        $info = $this->model->with(['category'])->where(['goods_id' => $goods_id])->findOrEmpty()->toArray();
        return $info;
    }

    public function add(array $data)
    {
        $data['create_time'] = time();
        $data['update_time'] = time();
        $result = $this->model->create($data);
        return $result->goods_id;
    }

    public function edit(int $goods_id, array $data)
    {
        $data['update_time'] = time();
        $this->model->where(['goods_id' => $goods_id])->update($data);
        return true;
    }

    public function del(int $goods_id)
    {
        $goods = $this->model->find($goods_id);
        if (empty($goods)) {
            throw new AdminException('pointshop_goods_not_exist');
        }
        $this->model->destroy($goods_id);
        return true;
    }

    public function setStatus(array $goods_ids, int $status)
    {
        $this->model->whereIn('goods_id', $goods_ids)->update(['status' => $status, 'update_time' => time()]);
        return true;
    }

    public function getCategory()
    {
        $categoryService = new PointCategoryService();
        return $categoryService->getList();
    }
}
