<?php

namespace HugCode\WeChat\Basics;

use HugCode\WeChat\Basics\Exception\ErrorCode;
use HugCode\WeChat\Basics\Exception\MessageException;

/**
 * Class BasicWeChat
 * @package WeChat\Contracts
 */
class BasicWeChat
{

    const API_BASE_URL_PREFIX = 'https://api.weixin.qq.com/'; // api请求地址前缀
    const API_BASE_URL = 'https://api.weixin.qq.com/cgi-bin/';  // api请求地址前缀
    const MP_BASE_URL = 'https://mp.weixin.qq.com/cgi-bin/'; // mp请求地址前缀
    const OAUTH_BASE_URL = 'https://open.weixin.qq.com/connect/oauth2/'; // 授权请求地址前缀

    /**
     * access_toke
     * @var string
     */
    protected $access_token;

    /**
     * 当前微信配置
     * @var DataArray
     */
    protected $config;


    /**
     * BasicWeChat constructor.
     * @param array $options
     * @param bool $v_token
     * @throws MessageException
     */
    public function __construct(array $options = [], $v_token = true)
    {
        if (empty($options['appid'])) {
            throw new MessageException(ErrorCode::CONFIG_ERROR_APPID);
        }
        if (empty($options['appsecret'])) {
            throw new MessageException(ErrorCode::CONFIG_ERROR_SECRET);
        }
        $this->config = new DataArray($options);
        if ($this->config->get('access_token')) {
            $this->access_token = $this->config->get('access_token');
        } else if ($v_token) {
            throw new MessageException(ErrorCode::GET_TOKEN_ERROR);
        }
    }

    /**
     * 获取访问 AccessToken
     * @return mixed|string
     * @throws MessageException
     */
    public function getAccessToken()
    {
        $data               = [
            'grant_type' => 'client_credential',
            'appid'      => $this->config->get('appid'),
            'secret'     => $this->config->get('appsecret'),
        ];
        $token              = HttpRequest::instance()->get(self::API_BASE_URL . 'token', $data)->toArray();
        $this->access_token = $token['access_token'];
        return $token;
    }

}
