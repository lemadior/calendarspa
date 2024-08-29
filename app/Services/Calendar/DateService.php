<?php

namespace App\Services\Calendar;

use DateTime;

class DateService
{
    /**  CalendarController get data from React in format 2024-03-28T15:02:17.882Z
     * Thus convert it to the DateTime the incoming value must be converted to proper format
     * aka 'YYYY-mm-dd HH:mm:ss'
     */
    function scrubDate($date): string
    {
        $arr = explode("T", $date);
        $arr[1] = substr($arr[1], 0, strripos($arr[1], '.'));

        return implode(' ', $arr);
    }

    function getDate(string $date): DateTime
    {
        // If date coming in 'YYYY-mm-dd' format. Without time.
        if (strlen($date) <= 10) {
            $date .= ' 00:00:00';
        }

        return (new DateTime())::createFromFormat('Y-m-d H:i:s', $date);
    }


    // Get first day of the month relative based on incoming date
    public function getFirstDayOfTheMonth(DateTime $date): DateTime
    {
        $year = $date->format('Y');
        $month = $date->format('m');

        $firstDayDate = $year . '-' . $month . '-01 00:00:00';

        return $this->getDate($firstDayDate);
    }


    /**
     * Generally the calendar will display six weeks. The first one always contain the first day in the month.
     * But first week can starts from date of previous month.
     * Get the first date for the first displayed week
     */
    public function getFirstDayOfFirstWeek(DateTime $baseDate): DateTime
    {
        $initialDay = $this->getFirstDayOfTheMonth($baseDate);

        $initialDayPosition = $initialDay->format('w');

        return $initialDay->modify('-' . $initialDayPosition . ' day');
    }
}
