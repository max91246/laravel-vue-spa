<?php

namespace App\Utility;

class Date
{
    /**
     * 將前端給的時間 range 轉換成 array 模式，包含 start 跟 end 兩個 key
     * @param $givenTime
     * @return array
     */
    public static function getExplodedDate($givenTime): array
    {
        $date = explode(' - ', $givenTime);
        return [
            'start' => $date[0] . ' 00:00:00',
            'end' => $date[1] . ' 23:59:59',
        ];
    }
}
