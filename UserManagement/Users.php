<?php

namespace HugCode\WeChat\UserManagement;

use HugCode\WeChat\Basics\BasicWeChat;
use HugCode\WeChat\Basics\HttpRequest;
use HugCode\WeChat\Basics\Exception\ErrorCode;
use HugCode\WeChat\Basics\Exception\MessageException;

class Users extends BasicWeChat
{

    const GET_USER_INFO = 'user/info'; // 获取用户基本信息


    /**
     * @Desc 获取用户基本信息
     * @param string $openid
     * @param string $lang
     * @return mixed
     * @throws MessageException
     * @author hug-code
     * @Time 2021/7/8 18:06
     */
    public function getUserInfo($openid = '', $lang = 'zh_CN')
    {
        if(empty($openid)){
            throw new MessageException(ErrorCode::PARAMS_ERROR_OPEN_ID);
        }
        $data        = [
            'access_token' => $this->access_token,
            'openid'       => $openid,
            'lang'         => $lang
        ];
        return HttpRequest::instance()->get(self::API_BASE_URL . self::GET_USER_INFO, $data)->toArray();
    }


}
