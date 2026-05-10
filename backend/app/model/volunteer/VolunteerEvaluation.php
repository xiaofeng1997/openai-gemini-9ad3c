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

namespace app\model\volunteer;

use core\base\BaseModel;

class VolunteerEvaluation extends BaseModel
{
    protected $pk = 'evaluation_id';
    protected $name = 'volunteer_evaluation';
    protected $type = ['images' => 'json'];
}
