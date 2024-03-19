<?php

namespace App\Traits;

use Carbon\Carbon;

trait UsabilityTime
{
    public function getUsabilityTime(Carbon $time):string
    {
        $month = $time->month;
        $months = [
            1 => 'янв',
            2 => 'фев',
            3 => 'мар',
            4 => 'апр',
            5 => 'май',
            6 => 'июн',
            7 => 'июл',
            8 => 'авг',
            9 => 'сен',
            10 => 'окт',
            11 => 'ноя',
            12 => 'дек'
        ];
        return $this->setAttribute('time',"$time->day $months[$month] $time->year");
    }
}
