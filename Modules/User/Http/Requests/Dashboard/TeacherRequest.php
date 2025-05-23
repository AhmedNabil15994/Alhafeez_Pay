<?php

namespace Modules\User\Http\Requests\Dashboard;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = [
            'name'       => 'required',
            "phone_code" => "required",
            "birth_date" => "nullable|date",
            "nationality_id"=>"required|exists:countries,id",
            "image"      => "nullable|image",
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

        if (strtolower($this->getMethod()) == "put") {
            $id = $this->id;
            $rule["id_image"]  = "nullable|image";
            $rule["password"]  = 'nullable|confirmed|min:6';
            $rule["id_number"].=",".$id;
            $rule["email"].=",".$id;
            $rule["mobile"][3] =  Rule::unique("users", "mobile")
            ->where("phone_code", $this->phone_code)->ignore($id, "id");
        }
        return $rule;
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
        $v = [
            'name.required'           => __('user::dashboard.users.validation.name.required'),
            'email.required'          => __('user::dashboard.users.validation.email.required'),
            'email.unique'            => __('user::dashboard.users.validation.email.unique'),
            'mobile.required'         => __('user::dashboard.users.validation.mobile.required'),
            'mobile.unique'           => __('user::dashboard.users.validation.mobile.unique'),
            'mobile.numeric'          => __('user::dashboard.users.validation.mobile.numeric'),
            'mobile.digits_between'   => __('user::dashboard.users.validation.mobile.digits_between'),
            'password.required'       => __('user::dashboard.users.validation.password.required'),
            'password.min'            => __('user::dashboard.users.validation.password.min'),
            'password.same'           => __('user::dashboard.users.validation.password.same'),
        ];

        return $v;
    }
}
