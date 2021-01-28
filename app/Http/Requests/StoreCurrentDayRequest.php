<?php

namespace App\Http\Requests;

use App\Diary;
use Illuminate\Foundation\Http\FormRequest;

class StoreCurrentDayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'timezone' => 'required|int|min:-12|max:12',
            'state' => 'required|string',
            'emotion' => 'string|nullable'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!in_array($this->state, (new Diary())->states)) {
                $validator->errors()->add('state', 'not correct!');
            }
        });
    }


}
