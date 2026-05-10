<?php
namespace app\service\admin\sys;

use app\model\sys\Dept;
use core\base\BaseAdminService;

class DeptService extends BaseAdminService
{
    public function getPage(array $where)
    {
        $field = 'id,name,parent_id,sort,status,create_time,update_time';
        $search_model = (new Dept())->withSearch(['name', 'status', 'create_time'], $where)
            ->field($field)
            ->order('sort asc, id desc');
        $list = $search_model->select()->toArray();
        
        if (!empty($list)) {
            $list = $this->buildTree($list, 0);
        }
        
        return $list;
    }

    public function getInfo(int $id)
    {
        $dept = (new Dept())->where('id', $id)->findOrEmpty();
        if ($dept->isEmpty()) {
            return [];
        }
        return $dept->toArray();
    }

    public function add(array $data)
    {
        $dept = new Dept();
        $dept->name = $data['name'];
        $dept->parent_id = $data['parent_id'];
        $dept->sort = $data['sort'];
        $dept->status = $data['status'];
        $dept->create_time = time();
        $dept->update_time = time();
        $dept->save();
        return true;
    }

    public function edit(int $id, array $data)
    {
        $dept = (new Dept())->where('id', $id)->findOrEmpty();
        if ($dept->isEmpty()) {
            throw new \Exception('部门不存在');
        }
        
        if (array_key_exists('name', $data) && $data['name'] !== null) {
            $dept->name = $data['name'];
        }
        if (array_key_exists('parent_id', $data) && $data['parent_id'] !== null) {
            $dept->parent_id = $data['parent_id'];
        }
        if (array_key_exists('sort', $data) && $data['sort'] !== null) {
            $dept->sort = $data['sort'];
        }
        if (array_key_exists('status', $data) && $data['status'] !== null) {
            $dept->status = $data['status'];
        }
        
        $dept->update_time = time();
        $dept->save();
        return true;
    }

    public function del(int $id)
    {
        $dept = (new Dept())->where('id', $id)->findOrEmpty();
        if ($dept->isEmpty()) {
            throw new \Exception('部门不存在');
        }
        $dept->delete();
        return true;
    }

    public function getAll()
    {
        return (new Dept())
            ->field('id,name,parent_id')
            ->order('sort asc, id desc')
            ->select()
            ->toArray();
    }

    public function getTree()
    {
        $list = $this->getAll();
        return $this->buildTree($list, 0);
    }

    private function buildTree(array $list, int $parent_id = 0)
    {
        $tree = [];
        foreach ($list as $item) {
            if ($item['parent_id'] == $parent_id) {
                $children = $this->buildTree($list, $item['id']);
                if (!empty($children)) {
                    $item['children'] = $children;
                }
                $tree[] = $item;
            }
        }
        return $tree;
    }
}