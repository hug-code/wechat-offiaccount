<?php

namespace HugCode\WeChat\MessageManagement;

use HugCode\WeChat\Basics\HttpRequest;
use HugCode\WeChat\Basics\BasicWeChat;
use HugCode\WeChat\Basics\Exception\ErrorCode;
use HugCode\WeChat\Basics\Exception\MessageException;

class BatchSends extends BasicWeChat
{

    const MS_TYPE_MP_NEWS = 'mpnews';  // 图文消息
    const MS_TYPE_TEXT = 'text';  // 文本消息
    const MS_TYPE_VOICE = 'voice';  // 语音消息
    const MS_TYPE_MUSIC = 'music';  // 音乐
    const MS_TYPE_IMAGE = 'image';  // 图片
    const MS_TYPE_VIDEO = 'video';  // 视频
    const MS_TYPE_WX_CARD = 'wxcard';  // 卡券


    const SEND = 'message/mass/send'; // 根据OpenID列表群发【订阅号不可用，服务号认证后可用】

    /**
     * @Desc 根据OpenID列表群发【订阅号不可用，服务号认证后可用】
     * @param array $data
     * @return mixed
     * @throws MessageException
     * @author hug-code
     * @Time 2021/7/26 16:57
     */
    public function send($data = [])
    {
        if (!isset($data['touser']) || empty($data['touser']) || !is_array($data['touser'])) {
            throw new MessageException(ErrorCode::PARAMS_ERROR_TO_USER_EMPTY);
        }
        $msgType = [
            self::MS_TYPE_MP_NEWS,
            self::MS_TYPE_TEXT,
            self::MS_TYPE_VOICE,
            self::MS_TYPE_MUSIC,
            self::MS_TYPE_IMAGE,
            self::MS_TYPE_VIDEO,
            self::MS_TYPE_WX_CARD
        ];
        if (!isset($data['msgtype']) || !in_array($data['msgtype'], $msgType)) {
            throw new MessageException(ErrorCode::PARAMS_ERROR_MSG_TYPE_ERROR);
        }

        $toUserCount = count($data['touser']);
        if ($toUserCount < 2 || $toUserCount > 10000) {
            throw new MessageException(ErrorCode::PARAMS_ERROR_TO_USER_ERROR);
        }

        $url = self::API_BASE_URL . self::SEND . '?access_token=' . $this->access_token;
        return HttpRequest::instance()->post($url, json_encode($data, JSON_UNESCAPED_UNICODE))->toArray();
    }

}
