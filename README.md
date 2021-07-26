# HugCode\WeChat
> 微信公众平台开发
>
> 官方文档：https://developers.weixin.qq.com/doc/offiaccount/Getting_Started/Overview.html

#### 配置与方法调用 (参考)
```php
$config = [
    'appid'     => '**',
    'appsecret' => '**',
    'agentid'   => 'access_token',
];
try {
    $result = (new \HugCode\WeChat\UserManagement\Users($config))->getUserInfo('open_id');
    var_dump($result);
} catch (\HugCode\WeChat\Basics\Exception\WeChatException $e) {
    var_dump($e->getErrorMessage(), $e->getErrorCode());
}
```
> 因工作上需要，功能未全部对接，可根据需要自行补充
