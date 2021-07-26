<?php
namespace HugCode\WeChat\AssetManagement;

use HugCode\WeChat\Basics\BasicWeChat;
use HugCode\WeChat\Basics\Exception\ErrorCode;
use HugCode\WeChat\Basics\Exception\MessageException;
use HugCode\WeChat\Basics\HttpRequest;

class Material extends BasicWeChat
{

    const MEDIA_GET = 'media/get'; // 获取临时素材
    const MEDIA_GET_JS_SDK = 'media/get/jssdk'; // 获取临时素材 (js sdk上传的语音)

    /**
     * @Desc 获取临时素材
     * @param string $media_id
     * @return mixed
     * @throws MessageException
     * @author hug-code
     * @Time 2021/7/9 16:55
     */
    public function getMedia($media_id = '')
    {
        if (empty($media_id)) {
            throw new MessageException(ErrorCode::CONFIG_ERROR_APPID);
        }
        $params = [
            'media_id'     => $media_id,
            'access_token' => $this->access_token
        ];
        $result = HttpRequest::instance()->get(self::API_BASE_URL . self::MEDIA_GET, $params);
        if(json_decode($result->result(), true)){
            return $result->toArray();
        }else{
            return $result->result();
        }
    }

    /**
     * @Desc 获取临时素材 (js sdk上传的语音)
     * @param string $media_id
     * @return mixed
     * @throws MessageException
     * @author hug-code
     * @Time 2021/7/9 16:55
     */
    public function getMediaJsSdk($media_id = '')
    {
        if (empty($media_id)) {
            throw new MessageException(ErrorCode::CONFIG_ERROR_APPID);
        }
        $params = [
            'media_id'     => $media_id,
            'access_token' => $this->access_token
        ];
        $result = HttpRequest::instance()->get(self::API_BASE_URL . self::MEDIA_GET_JS_SDK, $params);
        if(json_decode($result->result(), true)){
            return $result->toArray();
        }else{
            return $result->result();
        }
    }

}
