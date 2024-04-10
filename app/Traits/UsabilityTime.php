<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;

trait UsabilityTime
{
    public function getUsabilityTime(Carbon $time):string
    {
        $lang = App::getLocale();
        if ($lang == 'en'){
            return $this->setTimeENG($time);
        } else {
            return $this->setTimeRU($time);
        }
    }
    private function setTimeRU(Carbon $time){
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
    private function setTimeENG(Carbon $time){
        $month = $time->month;
        $months = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec'
        ];
        return $this->setAttribute('time',"$months[$month] $time->day $time->year");
    }
}
