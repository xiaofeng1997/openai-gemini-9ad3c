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

namespace app\service\admin\diy;

use app\model\diy\DiyTheme;
use app\dict\diy\DiyThemeColorDict;
use core\exception\AdminException;
use think\facade\Db;

/**
 * 自定义主题配色服务类
 * Class DiyThemeService
 * @package app\service\admin\diy
 */
class DiyThemeService
{
    /**
     * 获取主题列表
     * @return array
     */
    public function getDiyTheme()
    {
        return (new DiyTheme())->field('id,title,theme,is_selected')->order('id asc')->select()->toArray();
    }

    /**
     * 添加主题
     * @param $data
     * @return int
     */
    public function addDiyTheme($data)
    {
        $data['create_time'] = time();
        $data['update_time'] = time();
        
        // 如果是第一个主题，自动设为选中状态
        $count = (new DiyTheme())->count();
        if ($count == 0) {
            $data['is_selected'] = 1;
        }
        
        return (new DiyTheme())->create($data)->id;
    }

    /**
     * 编辑主题
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function editDiyTheme(int $id, array $data)
    {
        $data['update_time'] = time();
        return (new DiyTheme())->where([['id', '=', $id]])->update($data);
    }

    /**
     * 删除主题
     * @param int $id
     * @return bool
     */
    public function delDiyTheme(int $id)
    {
        $theme_info = (new DiyTheme())->field('is_selected')->where([['id', '=', $id]])->findOrEmpty()->toArray();
        
        if (empty($theme_info)) {
            throw new AdminException("主题不存在");
        }
        
        // 如果删除的是当前选中的主题，需要将第一个主题设为选中
        if ($theme_info['is_selected'] == 1) {
            $first_theme = (new DiyTheme())->where([['id', '<>', $id]])->order('id asc')->find();
            if ($first_theme) {
                (new DiyTheme())->where([['id', '=', $first_theme['id']]])->update(['is_selected' => 1]);
            }
        }
        
        return (new DiyTheme())->where([['id', '=', $id]])->delete();
    }

    /**
     * 设置主题
     * @param int $id
     * @return bool
     */
    public function setDiyTheme(int $id)
    {
        $theme_count = (new DiyTheme())->where([['id', '=', $id]])->count();
        
        if ($theme_count == 0) {
            throw new AdminException("主题不存在");
        }
        
        Db::startTrans();
        try {
            // 取消所有主题的选中状态
            (new DiyTheme())->where([['is_selected', '=', 1]])->update(['is_selected' => 0]);
            
            // 设置当前主题为选中状态
            (new DiyTheme())->where([['id', '=', $id]])->update(['is_selected' => 1]);
            
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            throw new AdminException($e->getMessage());
        }
    }

    /**
     * 获取主题色字典（调用字典类）
     * @return array
     */
    public function getThemeColorDict()
    {
        return DiyThemeColorDict::getThemeColor();
    }
}
