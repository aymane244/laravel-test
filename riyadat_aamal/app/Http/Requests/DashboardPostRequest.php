<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\RuleOldPassword;

class DashboardPostRequest extends FormRequest
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
            "email"=>['required','email'],
            "name"=>['required', 'string'],
            "current_password"=>['required','string',new RuleOldPassword],
            'new_password' => ['nullable','string'],
            "confirm_password"=>['nullable','string','same:new_password'],
            'logo' => ['nullable','image','mimes:jpg,jpeg,png,gif','max:2048'],
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
            'confirm_password.same' => 'confirmation de password est incorrect !!!',
            'logo.mimes' => "type de logo n'est pas accepté !!!"
        ];
    }
}
