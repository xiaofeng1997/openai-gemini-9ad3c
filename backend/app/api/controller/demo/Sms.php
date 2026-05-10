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

namespace app\api\controller\demo;

use app\service\core\sms\CoreSmsTemplateMessage;
use core\base\BaseController;
use think\Response;

class Sms extends BaseController
{
    /**
     * 发送业务通知短信
     * 示例：用于订单通知、余额变动等场景
     * @return Response
     */
    public function sendBusinessNotice()
    {
        $data = $this->request->params([
            [ 'mobile', '' ],
            [ 'amount', '' ],
            [ 'date', date('Y-m-d H:i:s') ],
            [ 'chinese', '' ],
            [ 'others', '' ]
        ]);
        
        if (empty($data['mobile'])) {
            return fail('手机号不能为空');
        }
        
        if (empty($data['amount'])) {
            return fail('金额不能为空');
        }
        
        if (empty($data['chinese'])) {
            return fail('业务备注不能为空');
        }   
        try {
            $sms_message = new CoreSmsTemplateMessage();
            $sms_message->sendBusinessNotice(
                $data['mobile'],
                $data['amount'],
                $data['date'],
                $data['chinese'],
                $data['others']
            );
            return success('业务通知短信发送成功');
        } catch (\Exception $e) {
            return fail($e->getMessage());
        }
    }
    
    /**
     * 发送验证码短信
     * 示例：用于登录、注册、找回密码等场景
     * @return Response
     */
    public function sendMemberVerifyCode()
    {
        $data = $this->request->params([
            [ 'mobile', '' ],
            [ 'code', '' ]
        ]);
        
        if (empty($data['mobile'])) {
            return fail('手机号不能为空');
        }
        
        if (empty($data['code'])) {
            return fail('验证码不能为空');
        }
        
        try {
            $sms_message = new CoreSmsTemplateMessage();
            $sms_message->sendMemberVerifyCode(
                $data['mobile'],
                $data['code']
            );
            return success('验证码短信发送成功');
        } catch (\Exception $e) {
            return fail($e->getMessage());
        }
    }
}
