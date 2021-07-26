<?php

namespace HugCode\WeChat\AccountManagement;

use HugCode\WeChat\Basics\BasicWeChat;
use HugCode\WeChat\Basics\HttpRequest;
use HugCode\WeChat\Basics\Exception\ErrorCode;
use HugCode\WeChat\Basics\Exception\MessageException;

class QRCode extends BasicWeChat
{

    const QR_CODE_CREATE = 'qrcode/create'; // 创建二维码ticket
    const SHOW_QR_CODE = 'showqrcode?ticket=';  // 通过ticket换取二维码

    /**
     * @Desc
     * @param int|string $scene 场景值ID，临时二维码时为32位非0整型，永久二维码时最大值为100000
     * @param int $type
     *              1:数值型临时二维码
     *              2:符串型临时二维码
     *              3:数值型永久二维码(此时expire参数无效)
     *              4:字符串型永久二维码(此时expire参数无效)
     * @param int $expire 该二维码有效时间，以秒为单位。 最大不超过2592000（即30天），此字段如果不填，则默认有效期为30秒。
     * @return array
     * @throws MessageException
     * @author hug-code
     * @Time 2021/7/8 16:15
     */
    public function getQrCode($scene = 0, $type = 0, $expire = 2592000)
    {
        if (empty($scene)) {
            throw new MessageException(ErrorCode::PARAMS_ERROR_SCENE_ID);
        }
        switch ($type) {
            case 1: // 数值型临时二维码
                $action_name = 'QR_SCENE';
                $action_info = ['scene' => ['scene_id' => $scene]];
                break;
            case 2: // 符串型临时二维码
                $action_name = 'QR_STR_SCENE';
                $action_info = ['scene' => ['scene_str' => $scene]];
                break;
            case 3: // 数值型永久二维码
                $action_name = 'QR_LIMIT_SCENE';
                $action_info = ['scene' => ['scene_id' => $scene]];
                break;
            case 4: // 字符串型永久二维码
                $action_name = 'QR_LIMIT_STR_SCENE';
                $action_info = ['scene' => ['scene_str' => $scene]];
                break;
            default:
                throw new MessageException(ErrorCode::PARAMS_ERROR_TYPE);
                break;
        }
        $data = [
            'action_name'    => $action_name,
            'expire_seconds' => $expire,
            'action_info'    => $action_info
        ];
        if (in_array($type, [3, 4])) {
            unset($data['expire_seconds']);
        }
        $request_url = self::API_BASE_URL . self::QR_CODE_CREATE . '?access_token=' . $this->access_token;
        return HttpRequest::instance()->post($request_url, json_encode($data))->toArray();
    }

    /**
     * @Desc 获取二维码图片
     * @method
     * @param string $ticket 传入由getQRCode方法生成的ticket参数
     * @return string 返回http地址
     * @author hug-code
     * @Time 2021/7/8 16:42
     */
    public function getShowQrCode($ticket)
    {
        return self::MP_BASE_URL . self::SHOW_QR_CODE . urlencode($ticket);
    }


}
