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

namespace app\service\core\menu;

use app\dict\sys\AppTypeDict;
use app\model\sys\SysMenu;
use app\service\admin\sys\MenuService;
use core\base\BaseCoreService;
use think\db\exception\DbException;
use think\facade\Cache;

/**
 * 系统菜单
 */
class CoreMenuService extends BaseCoreService
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new SysMenu();
    }

    /**
     * 加载菜单
     * @return array
     */
    public function loadMenu(array $menu_tree, string $app_type)
    {
        //加载系统
        $menu_list = [];
        $this->menuTreeToList($menu_tree, '', $app_type, $menu_list);
        return $menu_list;
    }

    /**
     * 菜单数转为列表
     * @param array $tree
     * @param string $parent_key
     * @param string $app_type
     * @param string $addon
     * @param array $menu_list
     */
    private function menuTreeToList(array $tree, string $parent_key = '', string $app_type = AppTypeDict::ADMIN, array &$menu_list = [])
    {
        if (is_array($tree)) {
            foreach ($tree as $key => $value) {
                $item = [
                    'menu_name' => $value[ 'menu_name' ],
                    'menu_short_name' => $value[ 'menu_short_name' ] ?? '',
                    'menu_key' => $value[ 'menu_key' ],
                    'app_type' => $app_type,
                    'parent_key' => $value[ 'parent_key' ] ?? $parent_key,
                    'menu_type' => $value[ 'menu_type' ],
                    'icon' => $value[ 'icon' ] ?? '',
                    'api_url' => $value[ 'api_url' ] ?? '',
                    'router_path' => $value[ 'router_path' ] ?? '',
                    'view_path' => $value[ 'view_path' ] ?? '',
                    'methods' => $value[ 'methods' ] ?? '',
                    'sort' => $value[ 'sort' ] ?? '',
                    'status' => 1,
                    'is_show' => $value[ 'is_show' ] ?? 1
                ];
                $refer = $value;
                if (isset($refer[ 'children' ])) {
                    unset($refer[ 'children' ]);
                    $menu_list[] = $item;
                    $p_key = $refer[ 'menu_key' ];
                    $this->menuTreeToList($value[ 'children' ], $p_key, $app_type, $menu_list);
                } else {
                    $menu_list[] = $item;
                }
            }
        }
    }

    /**
     * 安装菜单
     * @param array $menu_list
     * @return true
     */
    public function install(array $menu_list)
    {
        $this->model->replace()->insertAll($menu_list);
        // 清除缓存
        Cache::tag(MenuService::$cache_tag_name)->clear();
        return true;
    }

    /**
     * 获取path
     * @param $menu_key
     * @param $paths
     * @return string
     * @throws DbException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getRoutePathByMenuKey($menu_key, $paths = [])
    {
        $menu = $this->model->where([ [ 'menu_key', '=', $menu_key ] ])->field('parent_key,router_path')->find();
        if (empty($menu)) return '';
        array_unshift($paths, $menu[ 'router_path' ]);
        if (!empty($menu[ 'parent_key' ])) {
            return $this->getRoutePathByMenuKey($menu[ 'parent_key' ], $paths);
        } else {
            return implode('/', $paths);
        }
    }
}
