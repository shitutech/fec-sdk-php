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
}
