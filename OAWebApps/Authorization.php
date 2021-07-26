<?php

namespace HugCode\WeChat\OAWebApps;

use HugCode\WeChat\Basics\HttpRequest;
use HugCode\WeChat\Basics\BasicWeChat;
use HugCode\WeChat\Basics\Exception\ErrorCode;
use HugCode\WeChat\Basics\Exception\MessageException;

class Authorization extends BasicWeChat
{

    const OAUTH_AUTHORIZE = 'authorize'; // 授权，获取code
    const OAUTH_TOKEN = 'sns/oauth2/access_token'; // code换取网页授权access_token

    /**
     * @Desc 授权跳转接口
     * @param $callback
     * @param string $state
     * @param string $scope 应用授权作用域
     *              snsapi_base （不弹出授权页面，直接跳转，只能获取用户openid）
     *              snsapi_userinfo （弹出授权页面，可通过openid拿到昵称、性别、所在地。并且， 即使在未关注的情况下，只要用户授权，也能获取其信息 ）
     * @return string
     * @throws MessageException
     * @author hug-code
     * @Time 2021/7/12 15:39
     */
    public function getOauthRedirect($callback, $state = '', $scope = 'snsapi_userinfo')
    {
        if (empty($state)) {
            throw new MessageException(ErrorCode::PARAMS_ERROR_STATE_EMPTY);
        }
        if (empty($callback)) {
            throw new MessageException(ErrorCode::PARAMS_ERROR_REDIRECT_URI_EMPTY);
        }
        if (empty($scope)) {
            throw new MessageException(ErrorCode::PARAMS_ERROR_SCOPE_EMPTY);
        }
        $appid  = $this->config->get('appid');
        $url    = urlencode($callback);
        $params = "?appid={$appid}&redirect_uri={$url}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
        return self::OAUTH_BASE_URL . self::OAUTH_AUTHORIZE . $params;
    }

    /**
     * @Desc 通过code换取网页授权access_token
     * @return mixed
     * @throws MessageException
     * @author hug-code
     * @Time 2021/7/12 16:03
     */
    public function getOauthAccessToken()
    {
        $code = isset($_GET['code']) ? $_GET['code'] : '';
        if (empty($code)) {
            throw new MessageException(ErrorCode::PARAMS_ERROR_GET_CODE);
        }
        $params = [
            'appid'      => $this->config->get('appid'),
            'secret'     => $this->config->get('appsecret'),
            'code'       => $code,
            'grant_type' => 'authorization_code'
        ];
        return HttpRequest::instance()->get(self::API_BASE_URL_PREFIX . self::OAUTH_TOKEN, $params)->toArray();
    }

}
