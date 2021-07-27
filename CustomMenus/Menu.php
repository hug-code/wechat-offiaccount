<?php

namespace HugCode\WeChat\CustomMenus;

use HugCode\WeChat\Basics\HttpRequest;
use HugCode\WeChat\Basics\BasicWeChat;
use HugCode\WeChat\Basics\Exception\ErrorCode;
use HugCode\WeChat\Basics\Exception\MessageException;

class Menu extends BasicWeChat
{

    const CREATE = 'menu/create'; // 创建自定义菜单
    const DELETE = 'menu/delete'; // 删除自定义菜单
    const GET_CURRENT_SELF_MENU = 'get_current_selfmenu_info'; // 查询自定义菜单

    /**
     * @Desc 创建自定义菜单
     * @param array $data
     * @return mixed
     * @throws MessageException
     * @author hug-code
     * @Time 2021/7/27 13:39
     */
    public function create($data = [])
    {
        if (empty($data)) {
            throw new MessageException(ErrorCode::PARAMS_ERROR_EMPTY);
        }
        $url = self::API_BASE_URL . self::CREATE . '?access_token=' . $this->access_token;
        return HttpRequest::instance()->post($url, json_encode($data, JSON_UNESCAPED_UNICODE))->toArray();
    }

    /**
     * @Desc 查询自定义菜单
     * @return mixed
     * @throws MessageException
     * @author hug-code
     * @Time 2021/7/27 13:47
     */
    public function getCurrentSelfMenuInfo()
    {
        $url = self::API_BASE_URL . self::GET_CURRENT_SELF_MENU . '?access_token=' . $this->access_token;
        return HttpRequest::instance()->get($url)->toArray();
    }

    /**
     * @Desc 删除自定义菜单
     * @return mixed
     * @throws MessageException
     * @author hug-code
     * @Time 2021/7/27 13:52
     */
    public function delete()
    {
        $url = self::API_BASE_URL . self::DELETE . '?access_token=' . $this->access_token;
        return HttpRequest::instance()->get($url)->toArray();
    }

}
