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

namespace app\service\admin\volunteer;

use app\model\volunteer\Volunteer;
use app\model\member\Member;
use core\base\BaseAdminService;
use core\exception\AdminException;
use think\facade\Db;

class VolunteerApplyService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Volunteer();
    }

    public function getPage(array $where = [])
    {
        $field = 'volunteer_id, member_id, nickname, avatar, phone, skills, intro, point_threshold, status, apply_time, audit_time, audit_remark, create_time';
        $searchModel = $this->model->withSearch(['keyword', 'status'], $where)
            ->with(['member'])
            ->field($field)
            ->order('volunteer_id desc')
            ->append(['status_name']);
        return $this->pageQuery($searchModel);
    }

    public function getInfo(int $volunteer_id)
    {
        return $this->model->with(['member'])->where(['volunteer_id' => $volunteer_id])->findOrEmpty()->toArray();
    }

    public function audit(int $volunteer_id, int $status, string $remark = '')
    {
        $volunteer = $this->model->find($volunteer_id);
        if (empty($volunteer)) {
            throw new AdminException('volunteer_not_exist');
        }

        if ($volunteer['status'] != 0) {
            throw new AdminException('volunteer_cannot_audit');
        }

        $this->model->where(['volunteer_id' => $volunteer_id])->update([
            'status' => $status,
            'audit_time' => time(),
            'audit_remark' => $remark,
            'update_time' => time(),
        ]);

        return true;
    }
}
