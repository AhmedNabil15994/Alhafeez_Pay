<?php

namespace Modules\User\Http\Requests\Frontend;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'note'       => 'required',
            'status'       => 'required',
            'id_number'       => 'required|numeric|digits:12|unique:users,id_number',
            "nationality_id"=>"required|exists:countries,id",
            'mobile'     => [
                                'required',"numeric","digits_between:6,15",
                                 Rule::unique("users", "mobile")
                                 ->where("phone_code", $this->phone_code)
                             ],
            'email'      => 'nullable|email|unique:users,email',
            "id_image"   => "nullable|image"
        ];

        if (strtolower($this->getMethod()) == "put") {
            $id = $this->id;

            $rule["id_image"]  = "nullable|image";
            $rule["email"].=",".$id;
            $rule["id_number"].=",".$id;
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
            'note.required'           => __('user::dashboard.users.validation.note.required'),
            'status.required'           => __('user::dashboard.users.validation.status.required'),
            'name.required'           => __('user::dashboard.users.validation.name.required'),
            'email.required'          => __('user::dashboard.users.validation.email.required'),
            'email.unique'            => __('user::dashboard.users.validation.email.unique'),
            'mobile.required'         => __('user::dashboard.users.validation.mobile.required'),
            'mobile.unique'           => __('user::dashboard.users.validation.mobile.unique'),
            'mobile.numeric'          => __('user::dashboard.users.validation.mobile.numeric'),
            'mobile.digits_between'   => __('user::dashboard.users.validation.mobile.digits_between'),
            'id_number.required'         => __('user::dashboard.users.validation.id_number.required'),
            'id_number.unique'           => __('user::dashboard.users.validation.id_number.unique'),
            'id_number.numeric'          => __('user::dashboard.users.validation.id_number.numeric'),
            'id_number.digits'          => __('user::dashboard.users.validation.id_number.digits'),
        ];

        return $v;
    }
}
