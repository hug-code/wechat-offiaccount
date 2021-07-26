<?php
/**
 * @name: request请求
 * @Created by PhpStorm
 * @author: hug-code
 * @file: HttpRquest.php
 */

namespace HugCode\WeChat\Basics;

use HugCode\WeChat\Basics\Exception\MessageException;

class HttpRequest
{

    /**
     * @var string
     */
    protected $result;

    /**
     *
     * Instances of the derived classes.
     * @var array
     */
    protected static $instances = [];

    /**
     * Get instance of the derived class.
     * @return static
     */
    public static function instance()
    {
        $className = get_called_class();
        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new $className;
        }
        return self::$instances[$className];
    }

    /**
     * @desc: 获取数组结果
     * @return mixed
     * @throws MessageException
     * @author: hug-code
     * @Date: 2020/10/20 9:06
     */
    public function toArray()
    {
        $result = json_decode($this->result, true);
        if (isset($result['errcode'])) {
            if ($result['errcode'] == 0) {
                return $result;
            } else {
                $msg = SystemErrorCode::codeGetMessage($result['errcode'], $result['errmsg']);
                throw new MessageException($result['errcode'], $msg);
            }
        }else{
            return $result;
        }
    }

    /**
     * @desc: 获取结果
     * @return string
     * @author: hug-code
     * @Date: 2020/10/19 18:20
     */
    public function result()
    {
        return $this->result;
    }

    /**
     * @description: 以GET访问模拟访问
     * @param string $url 请求地址
     * @param array $query GET数据
     * @param array $headers 请求头
     * @return mixed
     * @author: injurys
     */
    public function get($url, $query = [], $headers = [])
    {
        $options['query'] = $query;
        self::request('get', $url, $options, $headers);
        return $this;
    }

    /**
     * @description: 以POST访问模拟访问
     * @param string $url 请求地址
     * @param array|string $data POST数据
     * @param array $headers 请求头
     * @return mixed
     * @author: injurys
     */
    public function post($url, $data = [], $headers = [])
    {
        $options['data'] = $data;
        self::request('post', $url, $options, $headers);
        return $this;
    }

    /**
     * @description: CURL模拟网络请求
     * @param string $method 请求方式
     * @param string $url 请求地址
     * @param array $options 请求参数
     * @param array $headers 请求头
     * @return mixed
     * @author: injurys
     */
    public function request($method, $url, $options = [], $headers = [])
    {
        $curl = curl_init();
        // GET参数设置
        if (!empty($options['query'])) {
            $url .= (stripos($url, '?') !== false ? '&' : '?') . http_build_query($options['query']);
        }
        // CURL头信息设置
        if (!empty($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        // POST数据设置
        if (strtolower($method) === 'post') {
            curl_setopt($curl, CURLOPT_POST, true);
            $options = is_array($options['data']) ? http_build_query($options['data']) : $options['data'];
            curl_setopt($curl, CURLOPT_POSTFIELDS, $options);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        list($content) = [curl_exec($curl), curl_close($curl)];
        $this->result = $content;
    }

}
