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

namespace app\adminapi\controller\volunteer;

use app\service\admin\volunteer\VolunteerApplyService;
use core\base\BaseAdminController;

class VolunteerApply extends BaseAdminController
{
    public function lists()
    {
        $data = $this->request->params([
            ['keyword', ''],
            ['status', ''],
        ]);
        return success((new VolunteerApplyService())->getPage($data));
    }

    public function info(int $volunteer_id)
    {
        return success((new VolunteerApplyService())->getInfo($volunteer_id));
    }

    public function audit()
    {
        $data = $this->request->params([
            ['volunteer_id', 0],
            ['status', 1],
            ['remark', ''],
        ]);
        (new VolunteerApplyService())->audit($data['volunteer_id'], $data['status'], $data['remark']);
        return success('EDIT_SUCCESS');
    }
}
