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
namespace app\service\core\sms\driver;

use core\exception\CommonException;
use core\exception\NoticeException;
use Exception;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Sms\V20190711\Models\SendSmsRequest;
use TencentCloud\Sms\V20190711\SmsClient;

class Tencent extends BaseSms
{
    protected $secret_id = '';
    protected $secret_key = '';
    protected $sign = '';
    protected $app_id = '';
    protected $error = '';

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->secret_id = $config[ 'secret_id' ] ?? '';
        $this->secret_key = $config[ 'secret_key' ] ?? '';
        $this->sign = $config[ 'sign' ] ?? '';
        $this->app_id = $config[ 'app_id' ] ?? '';
    }

    /**
     * 发送短信
     * @return bool|mixed
     */
    public function send(string $mobile, string $template_id, array $data = [])
    {
        try {
            $cred = new Credential($this->secret_id, $this->secret_key);
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint("sms.tencentcloudapi.com");

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);
            $client = new SmsClient($cred, 'ap-guangzhou', $clientProfile);
            if (isset($data['url_params'])) unset($data['url_params']);
            if (isset($data['param_json'])) unset($data['param_json']);
            $params = [
                'PhoneNumberSet' => [ '+86' . $mobile ],
                'TemplateID' => $template_id,
                'Sign' => $this->sign,
                'TemplateParamSet' => $data,
                'SmsSdkAppid' => $this->app_id,
            ];
            $req = new SendSmsRequest();
            $req->fromJsonString(json_encode($params, JSON_THROW_ON_ERROR));
            $resp = json_decode($client->SendSms($req)->toJsonString(), true, 512, JSON_THROW_ON_ERROR);
            if (isset($resp[ 'SendStatusSet' ]) && $resp[ 'SendStatusSet' ][ 0 ][ 'Code' ] == 'Ok') {
                return $resp;
            } else {
                $message = $resp[ 'SendStatusSet' ][ 0 ][ 'Message' ] ?? json_encode($resp, JSON_THROW_ON_ERROR);
                $this->error = $message;
                return false;
            }
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * 编辑签名
     * @param string $sign
     * @param string $mobile
     * @param string $code
     * @return mixed
     */
    public function modify(string $sign, string $mobile, string $code)
    {
        // 腾讯云短信编辑签名方法实现
        return [];
    }

    /**
     * 短信模板
     * @param int $page
     * @param int $limit
     * @param int $type
     * @return mixed
     */
    public function template(int $page, int $limit, int $type)
    {
        // 腾讯云短信模板方法实现
        return [];
    }

    /**
     * 申请短信
     * @param string $title
     * @param string $content
     * @param int $type
     * @return mixed
     */
    public function apply(string $title, string $content, int $type)
    {
        // 腾讯云短信申请方法实现
        return [];
    }

    /**
     * 模板列表
     * @param int $type
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function localTemplate(int $type, int $page, int $limit)
    {
        // 腾讯云短信模板列表方法实现
        return [];
    }

    /**
     * 记录
     * @param $id
     * @return mixed
     */
    public function record($id)
    {
        // 腾讯云短信记录方法实现
        return [];
    }

    public function getError()
    {
        return $this->error;
    }
}