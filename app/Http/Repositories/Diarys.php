<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.03.18
 * Time: 20:22
 */

namespace App\Http\Repositories;


use App\Diary;
use App\Http\Services\Time;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;

class Diarys
{
    private $_time;

    public function __construct()
    {
        $this->_time = new Time();
    }

    public function getCurrentDay(int $timezone) {
        return Diary::where('date', $this->_time->getNeededDateDependingOnTimezone($timezone))
            ->where('user_id', User::getId())
            ->first();
    }

    public function get($onlyQuery = false) {
        $diarys = Diary::select(['id', 'date', 'state', 'emotion', 'updated_at', 'created_at', 'timezone'])
            ->where('user_id', User::getId())
            ->orderBy('id', 'DESC');
        return ($onlyQuery) ? $diarys : $diarys->get();
    }

    public function stats() {
        return Diary::select([DB::raw('count(*) as count'), 'state'])
            ->where('user_id', User::getId())
            ->groupBy('state')
            ->orderBy('count', 'DESC')
            ->get();
    }
}