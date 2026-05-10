<?php
namespace app\model\sys;

use core\base\BaseModel;

class Dept extends BaseModel
{
    protected $name = 'sys_dept';
    protected $pk = 'id';

    public function searchNameAttr($query, $value, $data)
    {
        if ($value) {
            $query->whereLike('name', '%' . $value . '%');
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

    public function children()
    {
        return $this->hasMany(Dept::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Dept::class, 'parent_id', 'id');
    }

    public function positions()
    {
        return $this->hasMany(Position::class, 'dept_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(SysUser::class, 'dept_id', 'id');
    }
}