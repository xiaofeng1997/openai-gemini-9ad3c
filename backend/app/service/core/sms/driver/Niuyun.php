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

use app\dict\sys\SmsDict;
use app\service\core\http\HttpHelper;
use core\exception\CommonException;
use think\facade\Log;

class Niuyun extends BaseSms
{
    protected $username = '';
    protected $password = '';
    protected $signature = '';
    protected $error = '';
    private const SEND_URL = "https://api-shss.zthysms.com/v2/sendSmsTp";

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        Log::write("SEND_NY_SMS init " . json_encode($config, 256));
        $this->username = $config['username'] ?? '';
        $this->password = $config['password'] ?? '';
        $this->signature = $config['signature'] ?? '';
    }

    /**
     * 模版发送短信
     * @param string $mobile
     * @param string $template_id
     * @param array $data
     * @return void
     */
    public function send(string $mobile, string $template_id, array $data = [])
    {
        Log::write("SEND_NY_SMS pre " . json_encode($data, 256));
        if (empty($this->signature)) {
            $this->error = '签名未配置';
            return false;
        }
       $param_json = $data['param_json'] ?? '[]';    
        $url = self::SEND_URL;
        $data = $this->formatParams($data, $param_json);
        $params['records'] = [
            [
                'mobile' => $mobile,
                'tpContent' => $data
            ]
        ];
        $params['tpId'] = $template_id;
        $params['username'] = $this->username;
        $tKey = time();
        $params['tKey'] = $tKey;
        $params['password'] = md5(md5($this->password) . $tKey);
        $params['signature'] = $this->signature;
        Log::write("SEND_NY_SMS params " . json_encode($params, 256));
        try {
            $res = (new HttpHelper())->httpRequest('POST', $url, $params);
            Log::write("SEND_NY_SMS res " . json_encode($res, 256));
            if ($res['code'] != 200) {
                $this->error = 'ZT-' . $res['code'] . ":" . $res['msg'];
                return false;
            }
            return $res;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    private function formatParams($data, $params_json)
    {
        $params_type_arr = SmsDict::getApiParamsType();
        $type_arr = array_column($params_type_arr, null, 'type');
        $return = [];
        foreach ($params_json as $param => $validate) {
            $value = $data[$param];
            $pattern = $type_arr[$validate]['rule'] ?? '';
            $max = $type_arr[$validate]['max'] ?? 1;
            $min = $type_arr[$validate]['max'] ?? mb_strlen($value);
            if (!empty($pattern) && in_array($validate, [SmsDict::PARAMS_TYPE_CHINESE, SmsDict::PARAMS_TYPE_OTHERS])) {
                $value = str_replace(' ', '', $value);
                $value = str_replace('.', '', $value);
                $filtered = preg_replace($pattern, '', $value);
                $value = (mb_strlen($filtered, 'UTF-8') >= $min && mb_strlen($filtered, 'UTF-8') <= 35)
                    ? $filtered  // 长度合法，保留过滤后的字符串
                    : mb_substr($filtered, 0, $max);        // 长度非法，返回空字符串
            }
            if (empty($value)) {
                Log::write("SEND_NY_SMS 参数异常，无法发送 param:" . $param);
                throw new \Exception('NY:参数异常，无法发送');
            }
            $return[$param] = $value;
        }
        return $return;
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
        // 牛云短信编辑签名方法实现
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
        // 牛云短信模板方法实现
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
        // 牛云短信申请方法实现
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
        // 牛云短信模板列表方法实现
        return [];
    }

    /**
     * 记录
     * @param $id
     * @return mixed
     */
    public function record($id)
    {
        // 牛云短信记录方法实现
        return [];
    }

    public function getError()
    {
        return $this->error;
    }
}