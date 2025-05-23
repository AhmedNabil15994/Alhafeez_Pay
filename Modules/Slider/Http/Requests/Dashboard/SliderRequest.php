<?php
namespace Modules\Slider\Http\Requests\Dashboard;

use Modules\Slider\Enum\SliderType;
use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // dd($this->all());
        $rule = [
            "title"  => "required|array",
            "title.*"=> "required|max:255",
            "description"  => "nullable|array",
            "description.*"=> "nullable|max:255",
            "image" => "nullable|image",
            "type"   => "required|in:".implode(",",SliderType::getConstList()),
            "start_at"   => "required|date",
            "end_at"=> "required|date|after:".$this->start_at,
            "status" => "nullable",
        ];

        if ($this->type == SliderType::URL) {
            $rule["value"] = "required|url";
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
}
