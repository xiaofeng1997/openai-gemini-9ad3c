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

namespace app\service\core\wechat;

use core\base\BaseCoreService;
use core\exception\NoticeException;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\Kernel\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use app\service\core\wechat\CoreWechatLogService;
use app\service\core\wechat\CoreWechatTemplateNoticeService;
use app\service\core\wechat\CoreWechatTemplateData;

/**
 * easywechat主体提供
 * Class CoreWechatTemplateService
 * @package app\service\core\wechat
 */
class CoreWechatTemplateService extends BaseCoreService
{


    /**
     * 发送模板消息
     * @param string $open_id
     * @param string $wechat_template_id
     * @param array $data
     * @param string $first
     * @param string $remark
     * @param string $url
     * @param string $miniprogram
     * @param string $key 模板键名
     * @param array $params 模板参数
     * @param array $extra 额外信息
     * @return array|Collection|object|ResponseInterface|string
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function send(string $open_id, string $wechat_template_id, array $data, string $first, string $remark, string $url = '', $miniprogram = '', string $key = '', array $params = [], array $extra = [])
    {
        // 创建日志记录
        $core_wechat_log_service = new CoreWechatLogService();
        $log_id = $core_wechat_log_service->add([
            'key' => $key,
            'uid' => $extra['uid'] ?? 0,
            'member_id' => $extra['member_id'] ?? 0,
            'nickname' => $extra['nickname'] ?? '',
            'receiver' => $open_id,
            'params' => $params,
            'content' => [
                'template_id' => $wechat_template_id,
                'data' => $data,
                'first' => $first,
                'remark' => $remark,
                'url' => $url,
                'miniprogram' => $miniprogram
            ],
            'status' => 0, // 发送中
            'create_time' => time()
        ]);

        if (!empty($first)) $data[ 'first' ] = $first;
        if (!empty($remark)) $data[ 'remark' ] = $remark;
        $api = CoreWechatService::appApiClient();
        $param = [
            'touser' => $open_id,
            'template_id' => $wechat_template_id,
            'url' => $url,
            'miniprogram' => $miniprogram,
            'data' => $data,
        ];


        try {
            $result = $api->postJson('cgi-bin/message/template/send', $param);
            // 更新日志记录为成功
            $core_wechat_log_service->edit($log_id, [
                'status' => 1, // 发送成功
                'result' => $result,
                'send_time' => time()
            ]);
            return $result;
        } catch (\Exception $e) {
            // 更新日志记录为失败
            $core_wechat_log_service->edit($log_id, [
                'status' => 2, // 发送失败
                'result' => $e->getMessage(),
                'send_time' => time()
            ]);
            throw $e;
        }
    }

    /**
     * 删除
     * @param string $templateId
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function deletePrivateTemplate(string $templateId)
    {
        $api = CoreWechatService::appApiClient();

        return $api->postJson('cgi-bin/template/del_private_template', [
            'template_id' => $templateId,
        ]);
    }

    /**
     * 添加
     * @param string $shortId
     * @param string $keyword_name_list
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function addTemplate(string $shortId, string $keyword_name_list)
    {
        $api = CoreWechatService::appApiClient();

        return $api->postJson('cgi-bin/template/api_add_template', [
            'template_id_short' => $shortId,
            'keyword_name_list' => $keyword_name_list
        ]);
    }

    /**
     * 发送模板消息
     * @param string $open_id 用户open_id
     * @param string $template_key 模板键名
     * @param array $params 模板参数
     * @param string $url 跳转链接
     * @return array|Collection|object|ResponseInterface|string
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function sendTemplate(string $open_id, string $template_key, array $params, string $url = '')
    {
        try {
            // 获取微信模板配置
            $core_wechat_notice_service = new CoreWechatTemplateNoticeService();
            $template = $core_wechat_notice_service->getInfo($template_key);

            // 检查模板是否存在
            if (empty($template)) {
                throw new NoticeException('微信模板不存在');
            }
            
            // 检查是否启用微信消息
            if (empty($template['is_wechat'])) {
                throw new NoticeException('微信消息未启用');
            }
            
            // 检查微信模板ID是否配置
            if (empty($template['wechat_template_id'])) {
                throw new NoticeException('微信模板ID未配置');
            }
            
            // 检查openid是否为空
            if (empty($open_id)) {
                throw new NoticeException('用户openid不能为空');
            }
            
            // 组装微信模板数据
            $wechat_data = $this->makeUpWechatData($params, $template);
            
            // 发送微信模板消息
            return $this->send(
                $open_id,
                $template['wechat_template_id'],
                $wechat_data,
                $template['title'] ?? '',
                $template['remark'] ?? '',
                $url,
                '',
                $template_key,
                $params,
                [] // 额外信息
            );
        } catch (\Exception $e) {
            throw new NoticeException($e->getMessage());
        }
    }

    /**
     * 组装微信模板数据
     * @param array $params 业务参数
     * @param array $template 模板配置
     * @return array
     */
    private function makeUpWechatData(array $params, array $template)
    {
        $wechat_data = [];
        
        // 根据模板的参数映射组装微信模板数据
        $template_key = $template['key'];
        $template_config = CoreWechatTemplateData::getWechatTemplate($template_key);
        
        if (!empty($template_config) && !empty($template_config['content'])) {
            // 遍历模板配置中的content数组，根据映射关系组装数据
            foreach ($template_config['content'] as $item) {
                if (isset($item[2]) && isset($item[1])) {
                    // 提取微信模板字段名（如time4）
                    $wechat_field = $item[2];
                    // 提取参数占位符（如{create_time}）并去除大括号
                    $param_key = trim($item[1], '{}');
                    // 从业务参数中获取对应的值
                    $value = $params[$param_key] ?? '';
                    // 组装微信模板数据
                    $wechat_data[$wechat_field] = ['value' => $value];
                }
            }
        } else {
            // 通用模板数据组装
            foreach ($params as $key => $value) {
                $wechat_data[$key] = ['value' => $value];
            }
        }
        
        return $wechat_data;
    }
}
