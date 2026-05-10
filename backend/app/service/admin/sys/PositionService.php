<?php
namespace app\service\admin\sys;

use app\model\sys\Position;
use core\base\BaseAdminService;

class PositionService extends BaseAdminService
{
    public function getPage(array $where)
    {
        $field = 'id,name,dept_id,sort,status,create_time,update_time';
        $search_model = (new Position())->withSearch(['name', 'dept_id', 'status', 'create_time'], $where)
            ->with(['dept'])
            ->field($field)
            ->order('sort asc, id desc');
        $result = $this->pageQuery($search_model);
        
        if (!empty($result['data'])) {
            foreach ($result['data'] as &$item) {
                if (isset($item['dept']) && !empty($item['dept'])) {
                    $item['dept_name'] = $item['dept']['name'];
                } else {
                    $item['dept_name'] = '';
                }
            }
        }
        
        return $result;
    }

    public function getInfo(int $id)
    {
        $position = (new Position())->where('id', $id)->with(['dept'])->findOrEmpty();
        if ($position->isEmpty()) {
            return [];
        }
        return $position->toArray();
    }

    public function add(array $data)
    {
        $position = new Position();
        $position->name = $data['name'];
        $position->dept_id = $data['dept_id'];
        $position->sort = $data['sort'];
        $position->status = $data['status'];
        $position->create_time = time();
        $position->update_time = time();
        $position->save();
        return true;
    }

    public function edit(int $id, array $data)
    {
        $position = (new Position())->where('id', $id)->findOrEmpty();
        if ($position->isEmpty()) {
            throw new \Exception('岗位不存在');
        }
        
        if (array_key_exists('name', $data) && $data['name'] !== null) {
            $position->name = $data['name'];
        }
        if (array_key_exists('dept_id', $data) && $data['dept_id'] !== null) {
            $position->dept_id = $data['dept_id'];
        }
        if (array_key_exists('sort', $data) && $data['sort'] !== null) {
            $position->sort = $data['sort'];
        }
        if (array_key_exists('status', $data) && $data['status'] !== null) {
            $position->status = $data['status'];
        }
        
        $position->update_time = time();
        $position->save();
        return true;
    }

    public function del(int $id)
    {
        $position = (new Position())->where('id', $id)->findOrEmpty();
        if ($position->isEmpty()) {
            throw new \Exception('岗位不存在');
        }
        $position->delete();
        return true;
    }

    public function getAll()
    {
        $list = (new Position())->where('status', 1)
            ->with(['dept'])
            ->field('id,name,dept_id')
            ->order('sort asc, id desc')
            ->select()
            ->toArray();
            
        if (!empty($list)) {
            foreach ($list as &$item) {
                if (isset($item['dept']) && !empty($item['dept'])) {
                    $item['dept_name'] = $item['dept']['name'];
                } else {
                    $item['dept_name'] = '';
                }
            }
        }
        
        return $list;
    }

    public function getByDept(int $dept_id)
    {
        $list = (new Position())->where('dept_id', $dept_id)
            ->where('status', 1)
            ->field('id,name,dept_id')
            ->order('sort asc, id desc')
            ->select()
            ->toArray();
            
        if (!empty($list)) {
            foreach ($list as &$item) {
                if (isset($item['dept']) && !empty($item['dept'])) {
                    $item['dept_name'] = $item['dept']['name'];
                } else {
                    $item['dept_name'] = '';
                }
            }
        }
        
        return $list;
    }
}