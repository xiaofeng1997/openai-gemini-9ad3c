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

namespace app\service\api\volunteer;

use app\model\volunteer\VolunteerCategory;
use app\model\volunteer\VolunteerService;
use app\model\volunteer\Volunteer;
use think\facade\Cache;

class VolunteerServiceService
{
    public function getIndexData(int $member_id = 0)
    {
        $cacheKey = 'volunteer_index_' . $member_id;
        $cache = Cache::get($cacheKey);
        if ($cache) {
            return $cache;
        }

        $category = (new VolunteerCategory())
            ->where(['is_show' => 1])
            ->order('sort desc, category_id desc')
            ->select()
            ->toArray();

        $service = (new VolunteerService())
            ->where(['status' => 1])
            ->order('service_id desc')
            ->limit(10)
            ->select()
            ->toArray();

        $result = [
            'category' => $category,
            'service_list' => $service,
        ];

        Cache::set($cacheKey, $result, 60);
        return $result;
    }

    public function getCategory()
    {
        return (new VolunteerCategory())
            ->where(['is_show' => 1])
            ->order('sort desc, category_id desc')
            ->select()
            ->toArray();
    }

    public function getServiceList(array $params)
    {
        $where = [['status', '=', 1]];

        if (!empty($params['category_id'])) {
            $where[] = ['category_id', '=', $params['category_id']];
        }

        if (!empty($params['keyword'])) {
            $where[] = ['service_name', 'like', '%' . $params['keyword'] . '%'];
        }

        if (!empty($params['volunteer_id'])) {
            $where[] = ['volunteer_id', '=', $params['volunteer_id']];
        }

        $page = max(1, $params['page'] ?? 1);
        $limit = min(50, max(10, $params['limit'] ?? 20));

        $query = (new VolunteerService())->where($where);

        $total = $query->count();
        $list = $query
            ->with(['category'])
            ->order('service_id desc')
            ->page($page, $limit)
            ->select()
            ->toArray();

        foreach ($list as &$item) {
            if ($item['volunteer_id'] > 0) {
                $volunteer = (new Volunteer())->find($item['volunteer_id']);
                if ($volunteer) {
                    $item['volunteer_name'] = $volunteer['nickname'];
                    $item['volunteer_avatar'] = $volunteer['avatar'];
                }
            }
        }

        return [
            'data' => $list,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
        ];
    }

    public function getServiceDetail(int $service_id)
    {
        $service = (new VolunteerService())
            ->where(['service_id' => $service_id, 'status' => 1])
            ->with(['category'])
            ->find()
            ->toArray() ?? [];

        if (empty($service)) {
            throw new \core\exception\ApiException('volunteer_service_not_exist');
        }

        if ($service['volunteer_id'] > 0) {
            $volunteer = (new Volunteer())->find($service['volunteer_id']);
            if ($volunteer) {
                $service['volunteer_name'] = $volunteer['nickname'];
                $service['volunteer_avatar'] = $volunteer['avatar'];
                $service['volunteer_intro'] = $volunteer['intro'];
                $service['volunteer_phone'] = $volunteer['phone'];
            }
        }

        return $service;
    }

    public function getVolunteerProfile(int $volunteer_id)
    {
        $volunteer = (new Volunteer())
            ->where(['volunteer_id' => $volunteer_id, 'status' => 1])
            ->find()
            ->toArray() ?? [];

        if (empty($volunteer)) {
            throw new \core\exception\ApiException('volunteer_not_exist');
        }

        $service = (new VolunteerService())
            ->where(['volunteer_id' => $volunteer_id, 'status' => 1])
            ->select()
            ->toArray();

        $volunteer['service_list'] = $service;

        return $volunteer;
    }

    public function clearCache()
    {
        Cache::delete('volunteer_index_0');
    }
}
