<?php

namespace Modules\Authentication\Http\Requests\Frontend;

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
            'email'     => 'required|email|unique:vendors,email',
            'password'  => 'required|min:6',
            'password_confirm'  => 'required|same:password',
            'mobile'  => 'required|numeric|unique:vendors,mobile',
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

        $v = [
            'name.required'           => __('user::dashboard.users.validation.name.required'),
            'email.required'          => __('user::dashboard.users.validation.email.required'),
            'email.unique'            => __('user::dashboard.users.validation.email.unique'),
            'mobile.required'         => __('user::dashboard.users.validation.mobile.required'),
            'mobile.unique'           => __('user::dashboard.users.validation.mobile.unique'),
            'mobile.numeric'          => __('user::dashboard.users.validation.mobile.numeric'),
            'mobile.digits_between'   => __('user::dashboard.users.validation.mobile.digits_between'),
            'email.required'      =>   __('authentication::dashboard.login.validations.email.required'),
            'email.email'         =>   __('authentication::dashboard.login.validations.email.email'),
            'password.required'   =>   __('authentication::dashboard.login.validations.password.required'),
            'password.min'        =>   __('authentication::dashboard.login.validations.password.min'),
        ];

        return $v;
    }
}
