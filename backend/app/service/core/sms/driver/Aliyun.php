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

use AlibabaCloud\Client\AlibabaCloud;
use core\exception\NoticeException;
use app\service\core\sms\driver\BaseSms;
use Exception;

class Aliyun extends BaseSms
{
    protected $app_key = '';
    protected $secret_key = '';
    protected $sign = '';
    protected $error = '';

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->app_key = $config[ 'app_key' ] ?? '';
        $this->secret_key = $config[ 'secret_key' ] ?? '';
        $this->sign = $config[ 'sign' ] ?? '';
    }

    /**
     * 发送短信
     * @param string $mobile
     * @param string $template_id
     * @param array $data
     * @return array
     */
    public function send(string $mobile, string $template_id, array $data = [])
    {
        try {
            if (isset($data['param_json'])) unset($data['param_json']);
            AlibabaCloud::accessKeyClient($this->app_key, $this->secret_key)
                ->regionId('cn-hangzhou')
                ->asDefaultClient();
            $result = AlibabaCloud::rpcRequest()
                ->product('Dysmsapi')
                ->host('dysmsapi.aliyuncs.com')
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->debug(false)
                ->options([
                    'query' => [
                        'PhoneNumbers' => $mobile,
                        'SignName' => $this->sign,
                        'TemplateCode' => $template_id,
                        'TemplateParam' => json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
                    ],
                ])
                ->request();

            $res = $result->toArray();
            if (isset($res[ 'Code' ]) && $res[ 'Code' ] == 'OK') {
                return $res;
            }
            $message = $res[ 'Message' ] ?? $res;
            $this->error = $message;
            return false;
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
        // 阿里云短信编辑签名方法实现
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
        // 阿里云短信模板方法实现
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
        // 阿里云短信申请方法实现
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
        // 阿里云短信模板列表方法实现
        return [];
    }

    /**
     * 记录
     * @param $id
     * @return mixed
     */
    public function record($id)
    {
        // 阿里云短信记录方法实现
        return [];
    }

    public function getError()
    {
        return $this->error;
    }
}