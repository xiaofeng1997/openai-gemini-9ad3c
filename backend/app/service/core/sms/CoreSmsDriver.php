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

namespace app\service\core\sms;

use app\dict\sys\ConfigKeyDict;
use app\dict\sys\SmsDict;
use app\service\core\sys\CoreConfigService;
use app\service\core\sms\CoreSmsLogService;
use app\service\core\sms\CoreSmsNoticeService;
use core\base\BaseCoreService;
use core\exception\NoticeException;


/**
 * 短信配置服务层
 * Class CoreSmsDriver
 * @package app\service\core\sms
 */
class CoreSmsDriver extends BaseCoreService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 发送短信
     * @param string $mobile 手机号
     * @param array $params 模板参数
     * @param string $key 模板键名
     * @param string $template_id 模板ID
     * @param string $content 短信内容
     * @param array $url_params URL参数
     * @return bool
     * @throws NoticeException
     */
    public function send($mobile, $params, $key, $template_id, $content, $url_params=[])
    {
        //查询配置
        $config = $this->getDefaultSmsConfig();
        $sms_type = $config['sms_type'];
        if(empty($sms_type)) throw new NoticeException('SMS_TYPE_NOT_OPEN');
        //创建
        $core_sms_log_service = new CoreSmsLogService();
        $log_id = $core_sms_log_service->add([
            'mobile' => $mobile,
            'sms_type' => $sms_type,
            'key' => $key,
            'content' => $content,
            'template_id' => $template_id,
            'params' => $params,
            'status' => SmsDict::SENDING
        ]);
        // 直接实例化对应的驱动类
        $driverClass = 'app\\service\\core\\sms\\driver\\' . ucfirst($sms_type);
        if (!class_exists($driverClass)) {
            throw new NoticeException('SMS_DRIVER_NOT_FOUND');
        }
        $sms_driver = new $driverClass($config);
        $params = $this->makeUp($params, $content, $sms_type);
        $params['url_params'] = $url_params;
        $result = $sms_driver->send($mobile, $template_id, $params);
        if (!$result) {
            //失败修改短信记录
            $error = $sms_driver->getError();
            $core_sms_log_service->edit($log_id, [
                'status' => SmsDict::FAIL,
                'result' => $sms_driver->getError()
            ]);
            throw new NoticeException($error);
        }
        //成功修改短信记录
        $core_sms_log_service->edit($log_id, [
            'status' => SmsDict::SUCCESS,
            'result' => $result
        ]);
        return true;
    }


    public function makeUp($params, $content, $sms_type){
        if($sms_type != SmsDict::TENCENTSMS) return $params;
        if(empty($params)) return [];
        $temp_array = [];
        foreach($params as $k => $v){
            $index = strpos($content, '{' . $k . '}');
            if($index !== false){
                $temp_array[$index] = $v;
            }
        }
        if(!empty($temp_array)){
            return array_values($temp_array);
        }
        return [];
    }
    /**
     * 主要用于短信发送(todo 慎用!!!!!)
     * @return array
     */
    public function getDefaultSmsConfig()
    {
        $info = (new CoreConfigService())->getConfig(ConfigKeyDict::SMS)['value'] ?? [];
        if (empty($info))
            throw new NoticeException('NOTICE_SMS_NOT_OPEN');

        $sms_type = $info['default'] ?? '';
        $config = array(
            'sms_type' => $sms_type,
        );
        return array_merge($config, $info[$sms_type] ?? []);
    }

    /**
     * 发送模板短信
     * @param string $mobile 手机号
     * @param string $template_key 模板键名
     * @param array $params 模板参数
     * @return bool
     * @throws NoticeException
     */
    public function sendTemplate($mobile, $template_key, $params)
    {
        try {
            // 检查短信是否开启
            $this->getDefaultSmsConfig();
            // 获取短信模板配置
            $core_sms_notice_service = new CoreSmsNoticeService();
            $template = $core_sms_notice_service->getInfo($template_key);
            if (empty($template) || empty($template['is_sms'])) {
                throw new NoticeException('NOTICE_NOT_OPEN_SMS');
            }
            $content = $template['sms_content'] ?? $template['content'] ?? '';
            if (empty($content)) {
                throw new NoticeException('SMS_TEMPLATE_CONTENT_EMPTY');
            }
            // 替换模板变量
            foreach ($params as $key => $value) {
                $content = str_replace('{' . $key . '}', $value, $content);
            }
            $params['param_json'] = json_decode($template['param_json'] ?? '[]', true);
            // 发送短信
            return $this->send($mobile, $params, $template_key, $template['sms_id'] ?? '', $content);
        } catch (NoticeException $e) {
            // 捕获异常并重新抛出
            throw new NoticeException($e->getMessage());
        } catch (\Exception $e) {
            // 捕获其他异常
            throw new NoticeException($e->getMessage());
        }
    }

}