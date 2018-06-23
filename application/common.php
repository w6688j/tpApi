<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * curl_get
 *
 * @param string $url      get请求地址
 * @param int    $httpCode 返回状态码
 *
 * @author wangjian
 * @time   2018/6/4 11:27
 *
 * @return mixed
 */
function curl_get($url, &$httpCode = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //不做证书校验,部署在linux环境下请改为true
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $file_contents = curl_exec($ch);
    $httpCode      = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $file_contents;
}

/**
 * curl_post_raw
 *
 * @param string $url
 * @param        $rawData
 *
 * @author wangjian
 * @time   2018/6/23 19:19
 *
 * @return mixed
 */
function curl_post_raw($url, $rawData)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
    curl_setopt(
        $ch, CURLOPT_HTTPHEADER,
        [
            'Content-Type: text',
        ]
    );
    $data = curl_exec($ch);
    curl_close($ch);

    return ($data);
}

/**
 * getRandChars 获取随机字符串
 *
 * @param int $length 字符串长度，默认32位
 *
 * @author wangjian
 * @time   2018/6/4 20:13
 *
 * @return null|string
 */
function getRandChars($length = 32)
{
    $str    = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max    = strlen($strPol) - 1;

    for ($i = 0; $i < $length; $i++) {
        $str .= $strPol[rand(0, $max)];
    }

    return $str;
}