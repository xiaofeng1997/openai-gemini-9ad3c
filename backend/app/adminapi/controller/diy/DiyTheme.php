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

namespace app\adminapi\controller\diy;

use app\service\admin\diy\DiyThemeService;
use core\base\BaseAdminController;
use think\Response;

/**
 * 自定义主题配色控制器
 * Class DiyTheme
 * @description 自定义主题配色
 * @package app\adminapi\controller\diy
 */
class DiyTheme extends BaseAdminController
{
    /**
     * 获取主题列表
     * @description 获取主题列表
     * @return Response
     */
    public function getDiyTheme()
    {
        return success((new DiyThemeService())->getDiyTheme());
    }

    /**
     * 添加主题
     * @description 添加主题
     * @return Response
     */
    public function addDiyTheme()
    {
        $data = $this->request->params([
            [ 'title', '' ],
            [ 'theme', '', false ],
        ]);
        $id = (new DiyThemeService())->addDiyTheme($data);
        return success('ADD_SUCCESS', [ 'id' => $id ]);
    }

    /**
     * 编辑主题
     * @description 编辑主题
     * @param int $id
     * @return Response
     */
    public function editDiyTheme(int $id)
    {
        $data = $this->request->params([
            [ 'title', '' ],
            [ 'theme', '', false ],
        ]);
        (new DiyThemeService())->editDiyTheme($id, $data);
        return success('MODIFY_SUCCESS');
    }

    /**
     * 删除主题
     * @description 删除主题
     * @param int $id
     * @return Response
     */
    public function delDiyTheme(int $id)
    {
        (new DiyThemeService())->delDiyTheme($id);
        return success('DELETE_SUCCESS');
    }

    /**
     * 设置主题
     * @description 设置主题
     * @param int $id
     * @return Response
     */
    public function setDiyTheme(int $id)
    {
        (new DiyThemeService())->setDiyTheme($id);
        return success('MODIFY_SUCCESS');
    }

    /**
     * 获取主题色字典
     * @description 获取主题色字典（调用字典类）
     * @return Response
     */
    public function getThemeColorDict()
    {
        return success((new DiyThemeService())->getThemeColorDict());
    }
}
