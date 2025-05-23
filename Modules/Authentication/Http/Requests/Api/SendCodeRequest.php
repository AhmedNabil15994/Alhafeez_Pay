<?php

namespace Modules\Authentication\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SendCodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "phone_code"        => "required",
            'mobile'            => ['required','numeric','digits_between:3,20',Rule::exists("users", "mobile")->where(function ($query) {
                $query->where("phone_code", $this->phone_code);
            })]
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return  [];
    }
}
