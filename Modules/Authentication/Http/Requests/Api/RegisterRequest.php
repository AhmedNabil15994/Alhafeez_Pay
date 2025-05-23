<?php

namespace Modules\Authentication\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Modules\User\Enum\UserType;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => 'required',
            "phone_code" => "required",
            "birth_date" => "nullable|date",
            "nationality_id"=>"required|exists:countries,id",
            "level_id"   => "nullable|exists:student_levels,id",
            "image"      => "nullable|image",
            "type"       => "required|in:".\implode(",", UserType::getTypeRegisterApi()),
            "id_number"  => "required|unique:users,id_number",
            'mobile'     => [
                                'required',"numeric","digits_between:6,15",
                                 Rule::unique("users", "mobile")
                                 ->where("phone_code", $this->phone_code)
                             ],
            'email'      => 'nullable|email|unique:users,email',
            'password'   => 'required|confirmed|min:6',
            "id_image"   => "required|image"
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
}
