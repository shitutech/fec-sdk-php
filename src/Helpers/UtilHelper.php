<?php

namespace Shitutech\Fec\Helpers;

final class UtilHelper
{
    /**
     * 格式化数组数据，关键是去除两端空白字符
     *
     * @param mixed $params
     * @return array|string|null|mixed
     */
    public static function trimWhitespace($params)
    {
        if (is_array($params)) {
            if (empty($params)) {
                return [];
            }

            foreach ($params as $key => $val) {
                $params[$key] = self::trimWhitespace($val);
            }

            return $params;
        } elseif (is_null($params)) {
            return null;
        } elseif (is_string($params)) {
            return trim($params);
        } else {
            return $params;
        }
    }

    /**
     * 返回随机字符串
     *
     * @param int $len
     * @param bool $onlyNum
     * @return string
     */
    public static function randomStr(int $len, bool $onlyNum = false): string
    {
        $numbers = '0123456789';
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $arr = [];

        if ($onlyNum === true) {
            $initString = $numbers;
        } else {
            $initString = $numbers . $alphabet;
        }

        $initLen = strlen($initString) - 1;

        for ($i = 0; $i < $len; $i++) {
            $initStart = $onlyNum === true && $i == 0 ? 1 : 0;
            $arr[] = $initString[rand($initStart, $initLen)];
        }

        return implode('', $arr);
    }

    /**
     * 手机号验证
     * @param string $mobile
     * @param bool $disableException 是否抛异常，默认抛
     * @return bool
     * @throws \Exception
     */
    public static function verifyMobile(string $mobile, bool $disableException = false): bool
    {
        $checkRet = !trim($mobile) || !preg_match("/^1\d{10}$/", $mobile);

        if (!$disableException && $checkRet) {
            throw new \Exception('手机号不合法', 1000);
        }

        return $checkRet;
    }

    /**
     * 校验身份证号码
     * @param string $number
     * @param bool $disableException 是否抛异常，默认抛
     * @return bool
     * @throws \Exception
     */
    public static function verifyIdCard(string $number, bool $disableException = false): bool
    {
        $number = trim($number);
        if (empty($number) || strlen($number) != 18 || !preg_match("/^\d{17}[\dxX]$/", $number)) {
            if ($disableException) {
                return false;
            }

            throw new \Exception('身份证不合法', 1000);
        }

        $factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
        $sum = 0;

        for ($i = 0; $i < 17; $i++) {
            $sum += $number[$i] * $factor[$i];
        }

        $modulo = $sum % 11;

        $checker = '10X98765432';
        if ($checker[$modulo] != strtoupper($number[17])) {
            if ($disableException) {
                return false;
            }

            throw new \Exception('身份证不合法', 1000);
        }

        return true;
    }
}
