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

use app\model\member\Member;
use core\base\BaseModel;
use think\model\concern\SoftDelete;

class Volunteer extends BaseModel
{
    use SoftDelete;

    protected $pk = 'volunteer_id';
    protected $name = 'volunteer';
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
    protected $type = ['skills' => 'json'];

    const STATUS_APPLYING = 0;
    const STATUS_PASS = 1;
    const STATUS_REJECT = 2;

    public function getStatusNameAttr($value, $data)
    {
        $status = [
            0 => '申请中',
            1 => '已认证',
            2 => '已拒绝',
        ];
        return $status[$data['status']] ?? '';
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'member_id', 'member_id')
            ->joinType('left')
            ->bind(['nickname', 'mobile', 'headimg']);
    }

    public function searchKeywordAttr($query, $value, $data)
    {
        if ($value) {
            $query->whereLike('nickname|member.nickname', '%' . $this->handelSpecialCharacter($value) . '%');
        }
    }

    public function searchStatusAttr($query, $value, $data)
    {
        if ($value !== '') {
            $query->where('status', $value);
        }
    }
}
