<?php

use Illuminate\Database\Eloquent\Model;

if (!function_exists('validateURL')) {
    function validateURL($URL)
    {
        $pattern = "/^(?:([A-Za-z]+):)?(\/{0,3})([0-9.\-A-Za-z]+)(?::(\d+))?(?:\/([^?#]*))?(?:\?([^#]*))?(?:#(.*))?$/";
        if (preg_match($pattern, $URL)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('checkHex')) {
    /**
     * 私有 16进制检测
     *
     * @param $file
     * @param $size
     *
     * @return int
     *
     */
    function checkHex($file, $size)
    {
        $status = 0;
        $resource = fopen($file, 'rb');
        fseek($resource, 0);
        if ($size > 512) {
            // 若文件大于521B文件取头和尾
            $hexCode = bin2hex(fread($resource, 512));
            fseek($resource, $size - 512);
            //把文件指针移到文件尾部
            $hexCode .= bin2hex(fread($resource, 512));
        } else {
            //取全部
            $hexCode = bin2hex(fread($resource, $size));
        }
        fclose($resource);
        /** 匹配16进制中的 <% ( ) %> */ /** 匹配16进制中的 <? ( ) ?> */ /** 匹配16进制中的 <script | /script> 大小写亦可 */
        //整个类检测木马脚本的核心在这里  通过匹配十六进制代码检测是否存在木马脚本
        if (preg_match("/(3c25.*?28.*?29.*?253e)|(3c3f.*?28.*?29.*?3f3e)|(3C534352495054)|(2F5343524950543E)|(3C736372697074)|(2F7363726970743E)/is", $hexCode)) {
            $status = 5;//检测到风险
        }

        return $status;
    }
}

if (!function_exists('starMask')) {
    /**
     * 字串星号加密
     *
     * @param $str
     * @param  int  $first_keep
     * @param  int  $end_keep
     *
     * @return string
     */
    function starMask($str, $first_keep = 3, $end_keep = 3)
    {
        // 获取字符串长度
        $len = mb_strlen($str, 'utf-8');
        //如果字符创长度小于2，不做任何处理
        if ($len <= 2) {
            return $str;
        }

        // mb_substr — 获取字符串的部分
        $firstStr = mb_substr($str, 0, $first_keep, 'utf-8');
        $lastStr = mb_substr($str, -$end_keep, $end_keep, 'utf-8');

        return $firstStr . str_repeat("*", $len - ($first_keep + $end_keep)) . $lastStr;
    }
}

if (!function_exists('generateRandomString')) {
    /**
     * 生成指定長度的隨機亂碼
     *
     * @param $length
     * @return string
     */
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);

        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $characters[mt_rand(0, $charactersLength - 1)];
        }
        return $str;
    }
}

if (!function_exists('activityLog')) {
    /**
     * 操作紀錄
     *
     * @param $log
     * @param  Model|null  $performed
     * @param  array  $parameters
     * @param  string  $log_name
     */
    function activityLog($log, Model $performed = null, array $parameters = [], $log_name = '') {
        $activity = activity();

        if ($performed) {
            $activity->performedOn($performed);
        }

        if (auth()->check()) {
            $activity->causedBy(auth()->user());
        }

        if ($parameters) {
            $activity->withProperties($parameters);
        }

        if ($log_name) {
            $activity->useLog($log_name);
        }

        $activity->log($log);
    }
}
