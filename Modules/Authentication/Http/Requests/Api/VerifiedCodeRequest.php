<?php
namespace Modules\Authentication\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class VerifiedCodeRequest extends FormRequest
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
            "phone_code" => "required",
            'mobile'      =>[ "required","numeric", Rule::exists("users", "mobile")->where("phone_code", $this->phone_code)],
            "code"        => ["required", Rule::exists("mobile_codes", "code")
                            ->where("mobile", $this->mobile)
                            ->where("phone_code", $this->phone_code ?? "965")
             ]
        ];
    }
}
