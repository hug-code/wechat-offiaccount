<?php

namespace HugCode\WeChat\OAWebApps;

use HugCode\WeChat\Basics\Toole;
use HugCode\WeChat\Basics\HttpRequest;
use HugCode\WeChat\Basics\BasicWeChat;
use HugCode\WeChat\Basics\Exception\ErrorCode;
use HugCode\WeChat\Basics\Exception\MessageException;

class JsSdk extends BasicWeChat
{

    const FET_TICKET = 'ticket/getticket'; // 获取 jsapi_ticket

    /**
     * @Desc 获取 js sdk 签名
     * @param $url
     * @param string $jsapi_ticket
     * @param int $timestamp
     * @param string $noncestr
     * @return array
     * @throws MessageException
     * @author hug-code
     * @Time 2021/7/9 13:53
     */
    public function getSignature($url, $jsapi_ticket='', $timestamp = 0, $noncestr = '')
    {
        $ret = strpos($url, '#');
        $url = $ret ? trim(substr($url, 0, $ret)) : $url;

        if(empty($jsapi_ticket)){
            throw new MessageException(ErrorCode::PARAMS_ERROR_JS_API_TICKET);
        }
        if (empty($url)){
            throw new MessageException(ErrorCode::PARAMS_ERROR_URL);
        }

        $timestamp = !empty($timestamp) ? $timestamp : time();
        $noncestr  = !empty($noncestr) ? $noncestr : Toole::generateRandomStr();
        $arrayData = [
            "timestamp"    => $timestamp,
            "noncestr"     => $noncestr,
            "url"          => $url,
            "jsapi_ticket" => $jsapi_ticket
        ];
        ksort($arrayData);
        $paramString = [];
        foreach ($arrayData as $key => $value) {
            $paramString[] = $key . "=" . $value;
        }
        return [
            "url"       => $url,
            "noncestr"  => $noncestr,
            "timestamp" => $timestamp,
            "appid"     => $this->config->get('appid'),
            "signature" => sha1(implode('&', $paramString))
        ];
    }

    /**
     * @Desc 获取 jsapi_ticket
     * @return mixed
     * @throws \HugCode\WeChat\Basics\Exception\MessageException
     * @author hug-code
     * @Time 2021/7/9 13:35
     */
    public function getJsApiTicket()
    {
        $data = [
            'type'         => 'jsapi',
            'access_token' => $this->access_token
        ];
        return HttpRequest::instance()->get(self::API_BASE_URL. self::FET_TICKET, $data)->toArray();
    }


}
