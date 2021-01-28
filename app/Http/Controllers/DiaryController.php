<?php

namespace App\Http\Controllers;

use App\Diary;
use App\Http\Repositories\Diarys;
use App\Http\Requests\DiaryCurrentDayRequest;
use App\Http\Requests\StoreCurrentDayRequest;
use App\Http\Services\Time;
use App\User;
use Illuminate\Http\Request;
use Auth;

class DiaryController extends Controller
{
    private $currentTimezone = null;
    /**
     *  Gets current day info
     *
     * @param DiaryCurrentDayRequest $request
     * @param Diarys $diaryRepository
     */
    public function getCurrentDay(DiaryCurrentDayRequest $request, Diarys $diaryRepository, Diary $diary) {
        $currentDay = $this->getCurrentDayModel($request, $diaryRepository);
        $state = $currentDay ? $currentDay->state : false;
        $emotion = $currentDay ? $currentDay->emotion : false;
        $states = $diaryRepository->get();
        $locales = [];
        foreach($diary->states as $locale) {
            $locales[$locale] = __("messages.".$locale);
        }
        $statesData = $diary->statesData;
        return compact('state', 'states', 'locales', 'statesData', 'emotion');
    }

    /**
     *
     *  Sets current day info
     *
     * @param DiaryCurrentDayRequest $request
     * @param Diarys $diaryRepository
     */
    public function setCurrentDay(StoreCurrentDayRequest $request, Diarys $diaryRepository, Time $timeService) {
        $currentDay = $this->getCurrentDayModel($request, $diaryRepository);
        if (!$currentDay) {
            $currentDay = new Diary;
            $currentDay->date = $timeService->getNeededDateDependingOnTimezone($this->currentTimezone);
            $currentDay->user_id = User::getId();
            $currentDay->timezone = $this->currentTimezone;
        }
        $currentDay->state = $request->input('state');
        $currentDay->emotion = $request->input('emotion');
        $currentDay->save();
    }

    private function getCurrentDayModel(Request $request, Diarys $diaryRepository) {
        $this->currentTimezone = $request->input('timezone');
        return $diaryRepository->getCurrentDay($this->currentTimezone);
    }
}
