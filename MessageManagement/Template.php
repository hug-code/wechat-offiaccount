<?php

namespace HugCode\WeChat\MessageManagement;

use HugCode\WeChat\Basics\HttpRequest;
use HugCode\WeChat\Basics\BasicWeChat;
use HugCode\WeChat\Basics\Exception\ErrorCode;
use HugCode\WeChat\Basics\Exception\MessageException;

class Template extends BasicWeChat
{

    const SEND = 'message/template/send';

    /**
     * @Desc 发送模板消息
     * @param $data
     * @return mixed|string
     * @throws MessageException
     * @author hug-code
     * @Time 2021/7/26 13:22
     */
    public function send($data)
    {
        if (empty($data)) {
            throw new MessageException(ErrorCode::CONFIG_ERROR_APPID);
        }
        $url = self::API_BASE_URL . self::SEND . '?access_token=' . $this->access_token;
        return HttpRequest::instance()->post($url, json_encode($data))->toArray();
    }
}
