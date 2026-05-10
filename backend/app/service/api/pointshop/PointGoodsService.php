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
use think\facade\Cache;

class PointGoodsService extends BaseApiService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new GoodsModel();
    }

    public function getIndexData()
    {
        $cacheKey = 'pointshop_index_' . $this->member_id;
        $cache = Cache::get($cacheKey);
        if ($cache) {
            return $cache;
        }

        $category = (new PointCategory())
            ->where(['is_show' => 1])
            ->order('sort desc, category_id desc')
            ->select()
            ->toArray();

        $goods = $this->model
            ->where(['status' => 1])
            ->where('stock', '>', 0)
            ->order('sort desc, goods_id desc')
            ->limit(20)
            ->select()
            ->toArray();

        $result = [
            'category' => $category,
            'goods_list' => $goods,
        ];

        Cache::set($cacheKey, $result, 60);
        return $result;
    }

    public function getGoodsList(array $params)
    {
        $where = [['status', '=', 1], ['stock', '>', 0]];

        if (!empty($params['category_id'])) {
            $where[] = ['category_id', '=', $params['category_id']];
        }

        if (!empty($params['keyword'])) {
            $where[] = ['goods_name', 'like', '%' . $params['keyword'] . '%'];
        }

        $page = max(1, $params['page'] ?? 1);
        $limit = min(50, max(10, $params['limit'] ?? 20));

        $query = $this->model->where($where);

        $total = $query->count();
        $list = $query
            ->order('sort desc, goods_id desc')
            ->page($page, $limit)
            ->select()
            ->toArray();

        return [
            'data' => $list,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
        ];
    }

    public function getGoodsDetail(int $goods_id)
    {
        $cacheKey = 'pointshop_goods_' . $goods_id;
        $cache = Cache::get($cacheKey);
        if ($cache) {
            return $cache;
        }

        $goods = $this->model
            ->where(['goods_id' => $goods_id, 'status' => 1])
            ->find()
            ->toArray() ?? [];

        if (empty($goods)) {
            throw new \core\exception\ApiException('GOODS_NOT_EXIST');
        }

        Cache::set($cacheKey, $goods, 300);
        return $goods;
    }
}
