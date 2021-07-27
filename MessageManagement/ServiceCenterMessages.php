<?php

namespace HugCode\WeChat\MessageManagement;

use HugCode\WeChat\Basics\WxConstant;
use HugCode\WeChat\Basics\BasicWeChat;
use HugCode\WeChat\Basics\HttpRequest;
use HugCode\WeChat\Basics\Exception\ErrorCode;
use HugCode\WeChat\Basics\Exception\MessageException;

class ServiceCenterMessages extends BasicWeChat
{

    const SEND = 'message/custom/send'; // 客服接口-发消息

    /**
     * @Desc 客服接口-发消息
     * @param array $data
     * @return mixed
     * @throws MessageException
     * @author yashuai
     * @Time 2021/7/27 11:11
     */
    public function send($data = [])
    {
        if (!isset($data['touser']) || empty($data['touser']) || !is_string($data['touser'])) {
            throw new MessageException(ErrorCode::PARAMS_ERROR_TO_USER_EMPTY);
        }
        $msgType = [
            WxConstant::MS_TYPE_MP_NEWS,
            WxConstant::MS_TYPE_TEXT,
            WxConstant::MS_TYPE_VOICE,
            WxConstant::MS_TYPE_MUSIC,
            WxConstant::MS_TYPE_IMAGE,
            WxConstant::MS_TYPE_VIDEO,
            WxConstant::MS_TYPE_WX_CARD,
            WxConstant::MS_TYPE_NEWS,
            WxConstant::MS_TYPE_WX_APP,
        ];
        if (!isset($data['msgtype']) || !in_array($data['msgtype'], $msgType)) {
            throw new MessageException(ErrorCode::PARAMS_ERROR_MSG_TYPE_ERROR);
        }
        $url = self::API_BASE_URL . self::SEND . '?access_token=' . $this->access_token;
        return HttpRequest::instance()->post($url, json_encode($data, JSON_UNESCAPED_UNICODE))->toArray();
    }

}
