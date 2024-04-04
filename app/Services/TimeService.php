<?php

namespace App\Services;

class TimeService
{
    public function getUnixTime(string $date): bool|int
    {
        return strtotime($date);
    }
    public function compareUnixDates(int $date1,int $date2):bool
    {
        return $date1>$date2;
    }
}
