<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2018/6/4
 * Time: 20:09
 */

namespace app\api\service;

use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    /**
     * generateToken 生成随机Token
     *
     * @author wangjian
     * @time   2018/6/4 20:26
     * @return string
     */
    public static function generateToken()
    {
        // 32个字符组成一组随机字符串
        $randChars = getRandChars();
        // 用三组字符串进行md5加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        // salt 盐
        $salt = config('secure.token_salt');

        return md5($randChars . $timestamp . $salt);
    }

    /**
     * getCurrentTokenVar 获取当前Token对应值
     *
     * @param string $key 键名
     *
     * @author wangjian
     * @time   2018/6/9 17:41
     *
     * @return mixed
     * @throws TokenException
     * @throws \think\Exception
     */
    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()
            ->header('token');

        $vars = Cache::get($token);
        if (!$vars)
            throw new TokenException();

        if (!is_array($vars))
            $vars = json_decode($vars, true);

        if (!array_key_exists($key, $vars))
            throw new Exception('尝试获取的Token变量并不存在');

        return $vars[$key];
    }

    /**
     * getCurrentUID 获取当前UID
     *
     * @author wangjian
     * @time   2018/6/9 17:44
     * @return mixed
     * @throws Exception
     * @throws TokenException
     */
    public static function getCurrentUID()
    {
        $uid = self::getCurrentTokenVar('uid');

        return $uid;
    }
}