<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.03.18
 * Time: 21:30
 */

namespace App\Http\Services;


class Time
{
    public function getNeededDateDependingOnTimezone(int $timezone, $date = null, $format = "Y-m-d") {
        $timezoneSetting = $timezone > 0 ? '+' : ($timezone < 0 ? '-' : '');
        if ($timezoneSetting) {
            $timezoneSetting .= "{$timezone} hours";
        }
        return date($format, strtotime(($date ? $date." " : "").$timezoneSetting));
    }
}