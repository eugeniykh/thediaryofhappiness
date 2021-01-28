<?php

namespace App\Http\Controllers;

use App\Diary;
use App\Http\Repositories\Diarys;
use App\Http\Requests\EmotionUpdateRequest;
use App\Http\Services\Time;
use Carbon\Carbon;

class HomeController extends Controller
{

    /**
     * Show the application dashboard
     */
    public function index(Diary $diary)
    {
        $states = $diary->states;
        return view('home.index')->with(compact('states'));
    }

    /**
     * Show flow
     */
    public function flow(Diary $diary, Diarys $diaryRepository, Carbon $carbon, Time $time) {
        $states = $diaryRepository->get(true)->paginate(10);
        $states->setPath('');
        $statesData = $diary->statesData;
        return view('home.flow')->with(compact('states', 'statesData', 'carbon', 'time'));
    }

    /**
     * Show stats
     */
    public function stats(Diarys $diaryRepository) {
        $stats = $diaryRepository->stats();
        $numberFormatter = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
        return view('home.stats')->with(compact('stats', 'numberFormatter'));
    }

    /**
     * Show diary state
     */
    public function show(Diary $diary, Carbon $carbon, Time $time) {
        $statesData = $diary->statesData;
        return view('home.edit')->with(compact('diary', 'statesData', 'carbon', 'time'));
    }

    /**
     * Update emotion
     */
    public function update(EmotionUpdateRequest $request, Diary $diary) {
        $diary->emotion = $request->input('emotion');
        if ($diary->save()) {
            return redirect()->action('HomeController@flow')->with('status', 'Emotion updated!');
        }
        return redirect()->action('HomeController@flow')->with('status', 'Emotion not updated!');
    }
}
