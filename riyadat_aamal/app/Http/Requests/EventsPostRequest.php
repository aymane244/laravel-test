<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventsPostRequest extends FormRequest
{

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;
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
            "title"=>['required','string'],
            "start"=>['required','date',],
            'end' => ['required','date','after_or_equal:start'],
        ];
    }

     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'end.after_or_equal' => 'la date de fin doit être supérieure à la date de début !!!',
        ];
    }

}
