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

namespace app\service\admin\sms;

use app\dict\sys\SmsDict;
use app\service\core\sms\CoreNiuSmsService;
use core\base\BaseAdminService;
use core\exception\AdminException;
use core\exception\ApiException;

/**
 * 消息管理服务层
 */
class NiuSmsService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->niu_service = (new CoreNiuSmsService());
    }

    public function enableNiuSms($enable)
    {
        if ($enable == 1) {
            $config = $this->niu_service->getNiuLoginConfig(true);
            if (empty($config) || !isset($config[SmsDict::NIUSMS]) || empty($config[SmsDict::NIUSMS]['username']) || empty($config[SmsDict::NIUSMS]['password']) || empty($config[SmsDict::NIUSMS]['signature'])) {
                throw new AdminException("NIU_SMS_ENABLE_FAILED");
            }
            $this->niu_service->setNiuLoginConfig(['default' => SmsDict::NIUSMS]);
        } else {
            $this->niu_service->setNiuLoginConfig(['default' => '']);
        }
    }

    /**
     * 获取当前登录的牛云短信账号
     * @return array
     */
    public function getConfig()
    {
        $login_config = $this->niu_service->getNiuLoginConfig(true);
        return [
            'is_login' => empty($login_config[SmsDict::NIUSMS]) ? 0 : 1,
            'username' => $login_config[SmsDict::NIUSMS]['username'] ?? '',
            'is_enable' => (($login_config['default'] ?? '') == SmsDict::NIUSMS) ? 1 : 0,
        ];
    }

    /**
     * 获取套餐列表
     * @param $params
     * @return mixed
     */
    public function packageList($params)
    {
        $res = $this->niu_service->packageList($params);
        return $res;
    }

    /**
     * 发送动态码
     * @param $params
     * @return mixed
     */
    public function sendMobileCode($params)
    {
        $res = $this->niu_service->sendMobileCode($params);
        return $res;
    }

    /**
     * 发送动态码
     * @return mixed
     */
    public function captcha()
    {
        $res = $this->niu_service->captcha();
        return $res;
    }

    /**
     * 注册牛云短信账号
     * @param $data
     * @return mixed
     */
    public function registerAccount($data)
    {
        if (!empty($data['imgUrl']) && strstr($data['imgUrl'], 'http') === false) {
            $data['imgUrl'] = request()->domain() . "/" . $data['imgUrl'];
        } else {
            $data['imgUrl'] = $data['imgUrl'] ?? '';
        }
        $res = $this->niu_service->registerAccount($data);
        return $res;
    }

    /**
     * 登录牛云短信账号
     * @param $params
     * @return mixed
     */
    public function loginAccount($params)
    {
        $account_info = $this->niu_service->loginAccount($params);
        if ($account_info) {
            $this->niu_service->setNiuLoginConfig($params, true);
        }
        return $account_info;
    }

    /**
     * 编辑牛云短信账号信息（暂时只有 手机号和默认签名）
     * @param $username
     * @param $params
     * @return mixed
     */
    public function editAccount($username, $params)
    {
        $res = $this->niu_service->editAccount($username, $params);
        $this->niu_service->setNiuLoginConfig($params);
        return $res;
    }

    /**
     * 获取牛云短信账号信息
     * @param $username
     * @return mixed
     */
    public function accountInfo($username)
    {
        $res = $this->niu_service->accountInfo($username);
        return $res;
    }

    /**
     * 重置转牛云短信账号密码
     * @param $username
     * @param $params
     * @return array
     */
    public function resetPassword($username, $params)
    {
        $account_info = $this->accountInfo($username);
        $mobile_arr = explode(",", $account_info['mobiles']);
        if (!in_array($params['mobile'], $mobile_arr)) {
            throw new ApiException('ACCOUNT_BIND_MOBILE_ERROR');
        }
        $res = $this->niu_service->resetPassword($username, $params);
        $this->niu_service->setNiuLoginConfig(['username' => $username, 'password' => $res['newPassword']]);
        return [
            'password' => $res['newPassword'],
        ];
    }



    /**
     * 获取签名列表
     * @param $username
     * @return array
     */
    public function getSignList($username)
    {
        $res = $this->niu_service->signList($username);
        $return = $this->formatListPaginate($res['page']);
        $return['data'] = $res['signatures'];
        $config = $this->niu_service->getNiuLoginConfig();
        foreach ($return['data'] as &$item) {
            $item['auditResultName'] = SmsDict::getSignAuditType($item['auditResult']);
            $item['createTime'] = date('Y-m-d H:i:s', ($item['createTime'] / 1000));
            $item['is_default'] = ($config['signature'] == $item['sign']) ? 1 : 0;
        }
        return $return;
    }

    /**
     * 获取签名信息
     * @param $username
     * @param $signature
     * @return mixed
     */
    public function signInfo($username, $signature)
    {
        return $this->niu_service->signInfo($username, $signature);
    }

    /**
     * 获取创建签名初始化的配置信息
     * @return array
     */
    public function signCreateConfig()
    {
        return [
            'sign_source_list' => SmsDict::getSignSource(),
            'sign_type_list' => SmsDict::getSignType(),
            'sign_default_list' => SmsDict::getSignDefault()
        ];
    }

    /**
     * 签名创建
     * @param $username
     * @param $params
     */
    public function signCreate($username, $params)
    {
        if (!empty($params['imgUrl']) && strstr($params['imgUrl'], 'http') === false) {
            $params['imgUrl'] = request()->domain() . '/' . $params['imgUrl'];
        } else {
            $params['imgUrl'] = $params['imgUrl'] ?? '';
        }
        $res = $this->niu_service->signCreate($username, $params);
        if (!empty($res['failList'])) {
            throw new AdminException($res['failList'][0]['msg']);
        }
    }

    /**
     * 签名创建
     * @param $username
     * @param $params
     * @return array|mixed
     * @throws \Exception
     */
    public function signDelete($username, $params)
    {
        $config = $this->niu_service->getNiuLoginConfig();
        $params['password'] = $config['password'];
        $fail_list = $this->niu_service->signDelete($username, $params);
        if (in_array($config['signature'], $params['signatures']) && !in_array($config['signature'], $fail_list)) {
            $this->editAccount($username, ['signature' => '']);
        }
        return $fail_list;
    }



    /**
     * 格式化列表接口分页器
     * @param $data
     * @return array
     */
    private function formatListPaginate($data)
    {
        return [
            'total' => $data['total'],
            'per_page' => $data['size'],
            'current_page' => $data['currentPage'],
            'last_page' => $data['totalPage'],
        ];
    }

    /**
     * 获取订单列表
     * @param $username
     * @param $params
     * @return mixed
     */
    public function orderList($username, $params)
    {
        $res = $this->niu_service->orderList($username, $params);
        return $res;
    }

    /**
     * 创建订单
     * @param $username
     * @param $package_id
     * @return mixed
     */
    public function createOrder($username, $package_id)
    {
        $res = $this->niu_service->orderCreate($username, ['package_id' => $package_id]);
        return $res;
    }

    /**
     * 计算订单
     * @param $username
     * @param $package_id
     * @return mixed
     */
    public function calculate($username, $package_id)
    {
        $res = $this->niu_service->calculate($username, ['package_id' => $package_id]);
        return $res;
    }

    /**
     * 获取支付使用信息
     * @param $username
     * @param $params
     * @return mixed
     */
    public function getPayInfo($username, $params)
    {
        $res = $this->niu_service->orderPayInfo($username, $params);
        return $res;
    }

    /**
     * 获取订单信息
     * @param $username
     * @param $out_trade_no
     * @return mixed
     */
    public function orderInfo($username, $out_trade_no)
    {
        $res = $this->niu_service->orderInfo($username, $out_trade_no);
        return $res;
    }

    /**
     * 获取订单状态
     * @param $username
     * @param $out_trade_no
     * @return mixed
     */
    public function orderStatus($username, $out_trade_no)
    {
        $res = $this->niu_service->orderStatus($username, $out_trade_no);
        return $res;
    }

}
