<?php

namespace Modules\User\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = auth()->id();
        return [
            'name'       => 'required',
            "phone_code" => "required",
            "nationality_id"=>"required|exists:countries,id",
            "image"      => "nullable|image",
            "birth_date" => "nullable|date",
            "level_id"   => "sometimes|exists:student_levels,id",
            // "type"       => "required|in:".\implode(",", UserType::getTypeRegisterApi()),
            "id_number"  => "required|unique:users,id_number,".$id,
            'mobile'     => [
                                'required',"numeric","digits_between:6,15",
                                 Rule::unique("users", "mobile")
                                 ->where("phone_code", $this->phone_code)
                                 ->ignore($id, "id")
                             ],
            'email'      => 'nullable|email|unique:users,email,'.$id,
            'password'   => 'sometimes|confirmed|min:6',
            "id_image"   => "nullable|image"
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
            'name.required'           => __('user::api.users.validation.name.required'),
            'email.required'          => __('user::api.users.validation.email.required'),
            'email.unique'            => __('user::api.users.validation.email.unique'),
            'mobile.required'         => __('user::api.users.validation.mobile.required'),
            'mobile.unique'           => __('user::api.users.validation.mobile.unique'),
            'mobile.numeric'          => __('user::api.users.validation.mobile.numeric'),
            'mobile.digits_between'   => __('user::api.users.validation.mobile.digits_between'),
            'password.required'       => __('user::api.users.validation.password.required'),
            'password.min'            => __('user::api.users.validation.password.min'),
            'password.same'           => __('user::api.users.validation.password.same'),
        ];

        return $v;
    }
}
