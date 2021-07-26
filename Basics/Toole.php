<?php
/**
 * @Name: Toole.php
 * @Author: hug-code
 * @Time 2021/7/9 11:43
 */

namespace HugCode\WeChat\Basics;


class Toole
{

    /**
     * @Desc 生成随机字符串
     * @param int $length
     * @return string
     * @author hug-code
     * @Time 2021/7/9 11:44
     */
    public static function generateRandomStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str   = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $str;
    }

}
