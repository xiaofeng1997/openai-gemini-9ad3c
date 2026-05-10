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

namespace app\model\wechat;

use app\dict\notice\NoticeTypeDict;
use app\service\core\wechat\CoreWechatTemplateData;
use core\base\BaseModel;

/**
 * 系统微信模板消息发送记录
 * Class WechatLog
 * @package app\model\wechat
 */
class WechatLog extends BaseModel
{

    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    /**
     * 模型名称
     * @var string
     */
    protected $name = 'wechat_log';

    protected $type = [
        'send_time' => 'timestamp',
        'create_time' => 'timestamp',
        'update_time' => 'timestamp',
    ];

    // 设置json类型字段
    protected $json = ['params', 'content', 'result'];
    // 设置JSON数据返回数组
    protected $jsonAssoc = true;

    /**
     * 结果
     * @param $value
     * @param $data
     * @return string
     */
    public function getResultAttr($value, $data)
    {
        if ($value) {
            if(is_array($value)){
                $temp = $value;
            }else{
                $temp = json_decode($value, true);
            }
        }
        if (empty($temp)) {
            $temp = $value;
        }
        return $temp ?? '';
    }

    /**
     * 名称
     * @param $value
     * @param $data
     * @return string
     */
    public function getNameAttr($value, $data)
    {
        $name = '';
        if (!empty($data['key'])) {
            $temp = CoreWechatTemplateData::getWechatTemplate($data['key']);
            $name = $temp['name'] ?? $data['key'];
        }
        return $name;
    }

    /**
     * 消息标识
     * @param $query
     * @param $value
     * @return void
     */
    public function searchKeyAttr($query, $value)
    {
        if ($value) {
            $query->where('key', $value);
        }
    }

    /**
     * 接收人
     * @param $query
     * @param $value
     * @return void
     */
    public function searchReceiverAttr($query, $value)
    {
        if ($value != '') {
            $query->where('receiver', $value);
        }
    }

    /**
     * 发送时间搜索器
     * @param $query
     * @param $value
     * @param $data
     */
    public function searchSendTimeAttr($query, $value, $data)
    {
        $start_time = empty($value[0]) ? 0 : strtotime($value[0]);
        $end_time = empty($value[1]) ? 0 : strtotime($value[1]);
        if ($start_time > 0 && $end_time > 0) {
            $query->whereBetweenTime('send_time', $start_time, $end_time);
        } else if ($start_time > 0 && $end_time == 0) {
            $query->where([['send_time', '>=', $start_time]]);
        } else if ($start_time == 0 && $end_time > 0) {
            $query->where([['send_time', '<=', $end_time]]);
        }
    }

    /**
     * 创建时间搜索器
     * @param $query
     * @param $value
     * @param $data
     */
    public function searchCreateTimeAttr($query, $value, $data)
    {
        $start_time = empty($value[0]) ? 0 : strtotime($value[0]);
        $end_time = empty($value[1]) ? 0 : strtotime($value[1]);
        if ($start_time > 0 && $end_time > 0) {
            $query->whereBetweenTime('create_time', $start_time, $end_time);
        } else if ($start_time > 0 && $end_time == 0) {
            $query->where([['create_time', '>=', $start_time]]);
        } else if ($start_time == 0 && $end_time > 0) {
            $query->where([['create_time', '<=', $end_time]]);
        }
    }
}