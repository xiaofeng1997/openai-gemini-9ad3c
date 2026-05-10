<?php
namespace app\adminapi\controller\sys;

use app\service\admin\sys\DeptService;
use core\base\BaseAdminController;
use think\Response;

class Dept extends BaseAdminController
{
    public function lists()
    {
        $data = $this->request->params([
            ['name', ''],
            ['status', ''],
            ['create_time', []],
        ]);
        $list = (new DeptService())->getPage($data);
        return success($list);
    }

    public function info($id)
    {
        return success((new DeptService())->getInfo($id));
    }

    public function add()
    {
        $data = $this->request->params([
            ['name', ''],
            ['parent_id', 0],
            ['sort', 0],
            ['status', 1]
        ]);
        (new DeptService())->add($data);
        return success();
    }

    public function edit($id)
    {
        $data = $this->request->params([
            ['name', null],
            ['parent_id', null],
            ['sort', null],
            ['status', null]
        ]);
        (new DeptService())->edit($id, $data);
        return success();
    }

    public function del($id)
    {
        (new DeptService())->del($id);
        return success();
    }

    public function getAll()
    {
        $list = (new DeptService())->getAll();
        return success($list);
    }

    public function getTree()
    {
        $list = (new DeptService())->getTree();
        return success($list);
    }
}