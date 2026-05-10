<?php
namespace app\model\sys;

use core\base\BaseModel;

class Position extends BaseModel
{
    protected $name = 'sys_position';
    protected $pk = 'id';

    public function dept()
    {
        return $this->belongsTo(Dept::class, 'dept_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(SysUser::class, 'position_id', 'id');
    }

    public function searchNameAttr($query, $value, $data)
    {
        if ($value) {
            $query->whereLike('name', '%' . $value . '%');
        }
    }

    public function searchDeptIdAttr($query, $value, $data)
    {
        if ($value !== '') {
            $query->where('dept_id', $value);
        }
    }

    public function searchStatusAttr($query, $value, $data)
    {
        if ($value !== '') {
            $query->where('status', $value);
        }
    }

    public function searchCreateTimeAttr($query, $value, $data)
    {
        if (!empty($value)) {
            $query->whereBetweenTime('create_time', $value[0], $value[1]);
        }
    }
}