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

namespace app\service\api\pointshop;

use app\model\api\pointshop\PointGoods as GoodsModel;
use app\model\pointshop\PointCategory;
use app\service\core\member\CoreMemberAccountService;
use core\base\BaseApiService;

/**
 * API端积分商品服务层
 * Class PointGoodsService
 * @package app\service\api\pointshop
 */
class PointGoodsService extends BaseApiService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new GoodsModel();
    }

    /**
     * 获取商城首页数据
     * @return array
     */
    public function getIndexData()
    {
        $category = (new PointCategory())->where(['is_show' => 1])->order('sort desc, category_id desc')->select()->toArray();
        $goods = $this->model->where(['status' => 1])->order('sort desc, goods_id desc')->limit(10)->select()->toArray();

        return [
            'category' => $category,
            'goods_list' => $goods,
        ];
    }

    /**
     * 获取商品列表
     * @param array $params
     * @return array
     */
    public function getGoodsList(array $params)
    {
        $where = [['status', '=', 1]];
        if (!empty($params['category_id'])) {
            $where[] = ['category_id', '=', $params['category_id']];
        }
        if (!empty($params['keyword'])) {
            $where[] = ['goods_name', 'like', '%' . $params['keyword'] . '%'];
        }

        $page = $params['page'] ?? 1;
        $limit = $params['limit'] ?? 20;

        $list = $this->model->where($where)
            ->order('sort desc, goods_id desc')
            ->paginate([
                'list_rows' => $limit,
                'page' => $page,
            ]);

        return $list->toArray();
    }

    /**
     * 获取商品详情
     * @param int $goods_id
     * @return array
     */
    public function getGoodsDetail(int $goods_id)
    {
        $goods = $this->model->where(['goods_id' => $goods_id, 'status' => 1])->findOrEmpty()->toArray();

        if (empty($goods)) {
            throw new \core\exception\ApiException('GOODS_NOT_EXIST');
        }

        return $goods;
    }
}
