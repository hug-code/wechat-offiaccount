<?php

namespace HugCode\WeChat\Basics\Exception;

class ErrorCode
{

    const GET_TOKEN_ERROR = 10000;
    const GET_TICKET_ERROR = 10001;
    const CONFIG_ERROR_APPID = 10002;
    const CONFIG_ERROR_SECRET = 10003;

    const PARAMS_ERROR_SCENE_ID = 11001;
    const PARAMS_ERROR_TYPE = 11002;
    const PARAMS_ERROR_OPEN_ID = 11003;
    const PARAMS_ERROR_JS_API_TICKET = 11004;
    const PARAMS_ERROR_URL = 11005;
    const PARAMS_ERROR_MEDIA_ID = 11006;
    const PARAMS_ERROR_STATE_EMPTY = 11007;
    const PARAMS_ERROR_SCOPE_EMPTY = 11008;
    const PARAMS_ERROR_REDIRECT_URI_EMPTY = 11009;
    const PARAMS_ERROR_GET_CODE = 11010;


    public static $message_list = [
        self::GET_TOKEN_ERROR     => '【access_token】获取失败',
        self::GET_TICKET_ERROR    => '【jsapi_ticket】获取失败',
        self::CONFIG_ERROR_APPID  => '缺少配置参数【appid】',
        self::CONFIG_ERROR_SECRET => '缺少配置参数【appsecret】',

        self::PARAMS_ERROR_SCENE_ID           => '参数【scene_id】不能为空',
        self::PARAMS_ERROR_OPEN_ID            => '参数【open_id】不能为空',
        self::PARAMS_ERROR_TYPE               => '参数【type】不在范围',
        self::PARAMS_ERROR_JS_API_TICKET      => '参数【jsapi_ticket】不能为空',
        self::PARAMS_ERROR_URL                => '参数【url】不能为空',
        self::PARAMS_ERROR_MEDIA_ID           => '参数【media_id】不能为空',
        self::PARAMS_ERROR_SCOPE_EMPTY        => '参数【scope】不能为空',
        self::PARAMS_ERROR_STATE_EMPTY        => '参数【state】不能为空',
        self::PARAMS_ERROR_REDIRECT_URI_EMPTY => '参数【redirect_uri】不能为空',
        self::PARAMS_ERROR_GET_CODE           => '未获取到【code】参数',
    ];

}
