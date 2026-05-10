<?php
namespace app\adminapi\controller\sys;

use app\service\admin\sys\PositionService;
use core\base\BaseAdminController;
use think\Response;

class Position extends BaseAdminController
{
    public function lists()
    {
        $data = $this->request->params([
            ['name', ''],
            ['dept_id', ''],
            ['status', ''],
            ['create_time', []],
        ]);
        $list = (new PositionService())->getPage($data);
        return success($list);
    }

    public function info($id)
    {
        return success((new PositionService())->getInfo($id));
    }

    public function add()
    {
        $data = $this->request->params([
            ['name', ''],
            ['dept_id', 0],
            ['sort', 0],
            ['status', 1]
        ]);
        (new PositionService())->add($data);
        return success();
    }

    public function edit($id)
    {
        $data = $this->request->params([
            ['name', null],
            ['dept_id', null],
            ['sort', null],
            ['status', null]
        ]);
        (new PositionService())->edit($id, $data);
        return success();
    }

    public function del($id)
    {
        (new PositionService())->del($id);
        return success();
    }

    public function getAll()
    {
        $list = (new PositionService())->getAll();
        return success($list);
    }

    public function getByDept($dept_id)
    {
        $list = (new PositionService())->getByDept($dept_id);
        return success($list);
    }
}