<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntrepriseUpdateRequest extends FormRequest
{

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    // /**
    //  * The URI that users should be redirected to if validation fails.
    //  *
    //  * @var string
    //  */
    // protected $redirect = '/dashboard';


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
            "name"=>['required', 'string','unique:entreprise,name,'.auth()->user()->id],
            "type_entreprise"=>['required','in:Auto entrepreneur,Sarl,Société anonyme'],
            "email"=>['required','email','unique:entreprise,email,'.auth()->user()->id],
            'tele' => ['nullable','string','unique:entreprise,tele,'.auth()->user()->id],

            'num_rc' => ['nullable','string'],
            'ide_fiscal' => ['nullable','string'],
            'num_cnss' => ['nullable','string'],
            'num_ice' => ['nullable','string'],

            'adress' => ['required','string'],
            'facebook' => ['nullable','string','active_url'],
            'website' => ['nullable','string','active_url'],
            'instagram' => ['nullable','string','active_url'],
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
            'name.required' =>  'name is required',
            'name.unique' =>  'name is already exist',
            'type_entreprise.required' => "Type d'entreprise message is required",
            'email.required' =>  'email is required',
            'email.unique' =>  'email is already exist',
            'tele.unique' =>  'phone number is already exist',

        ];
    }

}
