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

use app\model\pointshop\PointGoods;
use app\model\pointshop\PointCategory;
use think\facade\Cache;

class PointGoodsService
{
    public function getIndexData(int $member_id = 0)
    {
        $cacheKey = 'pointshop_index_' . $member_id;
        $cache = Cache::get($cacheKey);
        if ($cache) {
            return $cache;
        }

        $category = (new PointCategory())
            ->where(['is_show' => 1])
            ->order('sort desc, category_id desc')
            ->select()
            ->toArray();

        $goods = (new PointGoods())
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

        $query = (new PointGoods())->where($where);

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

        $goods = (new PointGoods())
            ->where(['goods_id' => $goods_id, 'status' => 1])
            ->find()
            ->toArray() ?? [];

        if (empty($goods)) {
            throw new \core\exception\ApiException('pointshop_goods_not_exist');
        }

        Cache::set($cacheKey, $goods, 300);
        return $goods;
    }

    public function clearGoodsCache(int $goods_id)
    {
        Cache::delete('pointshop_goods_' . $goods_id);
        Cache::delete('pointshop_index_0');
    }
}
