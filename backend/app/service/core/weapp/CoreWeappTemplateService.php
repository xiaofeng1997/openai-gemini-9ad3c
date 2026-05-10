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

namespace app\service\core\weapp;

use core\base\BaseCoreService;
use core\exception\NoticeException;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\Kernel\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use think\facade\Log;
use app\service\core\weapp\CoreWeappLogService;
use app\service\core\weapp\CoreWeappTemplateData;
use app\service\core\weapp\CoreWeappTemplateNoticeService;

/**
 * 微信小程序服务提供
 * Class CoreWeappTemplateService
 * @package app\service\core\weapp
 */
class CoreWeappTemplateService extends BaseCoreService
{
    /**
     * 订阅消息发送
     * @param string $template_id
     * @param string $touser
     * @param array $data
     * @param string $page
     * @param string $key 模板键名
     * @param array $params 模板参数
     * @param array $extra 额外信息
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     */
    public function send(string $template_id, string $touser, array $data, string $page = '', string $key = '', array $params = [], array $extra = []){
        // 创建日志记录
        $core_weapp_log_service = new CoreWeappLogService();
        $log_id = $core_weapp_log_service->add([
            'key' => $key,
            'uid' => $extra['uid'] ?? 0,
            'member_id' => $extra['member_id'] ?? 0,
            'nickname' => $extra['nickname'] ?? '',
            'receiver' => $touser,
            'params' => $params,
            'content' => [
                'template_id' => $template_id,
                'data' => $data,
                'page' => $page
            ],
            'status' => 0, // 发送中
            'create_time' => time()
        ]);
        $api = CoreWeappService::appApiClient();
        try {
            $res = $api->postJson('cgi-bin/message/subscribe/send', [
                'template_id' => $template_id, // 所需下发的订阅模板id
                'touser' => $touser,     // 接收者（用户）的 openid
                'page' => $page,       // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
                'data' => $data,
            ]);
            Log::write('小程序消息发送RESPONSE'.json_encode($res->toArray(),256));
            
            // 更新日志记录为成功
            $core_weapp_log_service->edit($log_id, [
                'status' => 1, // 发送成功
                'result' => $res,
                'send_time' => time()
            ]);
            
            return $res;
        } catch (\Exception $e) {
            // 更新日志记录为失败
            $core_weapp_log_service->edit($log_id, [
                'status' => 2, // 发送失败
                'result' => $e->getMessage(),
                'send_time' => time()
            ]);
            throw new NoticeException($e->getMessage());
        }
    }

    /**
     * 组合模板并添加至帐号下的个人模板库
     * @param $tid
     * @param $kidList
     * @param $sceneDesc
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function addTemplate($tid, $kidList, $sceneDesc){
//        $tid = 563;     // 模板标题 id，可通过接口获取，也可登录小程序后台查看获取
//        $kidList = [1, 2];      // 开发者自行组合好的模板关键词列表，可以通过 `getTemplateKeywords` 方法获取
//        $sceneDesc = '提示用户图书到期';    // 服务场景描述，非必填
        $api = CoreWeappService::appApiClient();
        return $api->postJson('wxaapi/newtmpl/addtemplate', [
            'tid' => $tid,
            'kidList' => $kidList,
            'sceneDesc' => $sceneDesc,
        ]);
    }

    /**
     * 删除帐号下的个人模板
     * @param $template_id
     * @return array|Collection|object|ResponseInterface|string
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function deleteTemplate($template_id){
        $api = CoreWeappService::appApiClient();
        return $api->postJson('wxaapi/newtmpl/deltemplate', [
            'priTmplId' => $template_id,
        ]);
    }

    /**
     * 发送模板消息
     * @param string $open_id 用户open_id
     * @param string $template_key 模板键名
     * @param array $params 模板参数
     * @param string $page 跳转页面
     * @return array|Collection|object|ResponseInterface|string
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function sendTemplate(string $open_id, string $template_key, array $params, string $page = '')
    {
        try {
            // 获取微信小程序模板配置
            $core_weapp_notice_service = new CoreWeappTemplateNoticeService();
            $template = $core_weapp_notice_service->getInfo($template_key);

            // 检查模板是否存在
            if (empty($template)) {
                throw new NoticeException('微信小程序模板不存在');
            }
            
            // 检查是否启用小程序消息
            if (empty($template['is_weapp'])) {
                throw new NoticeException('微信小程序消息未启用');
            }
            
            // 检查小程序模板ID是否配置
            if (empty($template['weapp_template_id'])) {
                throw new NoticeException('微信小程序模板ID未配置');
            }
            // 检查openid是否为空
            if (empty($open_id)) {
                throw new NoticeException('用户openid不能为空');
            }
            // 组装小程序模板数据
            $weapp_data = $this->makeUpWeappData($params, $template);
            
            // 发送小程序模板消息
            return $this->send(
                $template['weapp_template_id'],
                $open_id,
                $weapp_data,
                $page,
                $template_key,
                $params,
                [] // 额外信息
            );
        } catch (\Exception $e) {
            throw new NoticeException($e->getMessage());
        }
    }

    /**
     * 组装小程序模板数据
     * @param array $params 业务参数
     * @param array $template 模板配置
     * @return array
     */
    private function makeUpWeappData(array $params, array $template)
    {
        $weapp_data = [];
        
        // 根据模板的参数映射组装小程序模板数据
        $template_key = $template['key'];
        $template_config = CoreWeappTemplateData::getWeappTemplate($template_key);
        
        if (!empty($template_config) && !empty($template_config['content'])) {
            // 遍历模板配置中的content数组，根据映射关系组装数据
            foreach ($template_config['content'] as $item) {
                if (isset($item[2]) && isset($item[1])) {
                    // 提取小程序模板字段名（如character_string1）
                    $weapp_field = $item[2];
                    // 提取参数占位符（如{order_no}）并去除大括号
                    $param_key = trim($item[1], '{}');
                    // 从业务参数中获取对应的值
                    $value = $params[$param_key] ?? '';
                    // 组装小程序模板数据
                    $weapp_data[$weapp_field] = ['value' => $value];
                }
            }
        } else {
            // 通用模板数据组装
            foreach ($params as $key => $value) {
                $weapp_data[$key] = ['value' => $value];
            }
        }
        
        return $weapp_data;
    }

}