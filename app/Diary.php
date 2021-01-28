<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    protected $table = 'diary';

    public $states = [
        'happy',
        'good_day',
        'ordinary_day',
        'bad_day',
        'disappointed'
    ];

    public $statesData = [
        'happy' => ['color' => '#c3e6cb', 'textColor' => '#155724'],
        'good_day' => ['color' => '#d1ecf1', 'textColor' => '#0c5460'],
        'ordinary_day' => ['color' => '#d6d8db', 'textColor' => '#383d41'],
        'bad_day' => ['color' => '#ffeeba', 'textColor' => '#856404'],
        'disappointed' => ['color' => '#f5c6cb', 'textColor' => '#721c24']
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'state', 'date', 'user_id', 'timezone', 'emotion'
    ];
}
