<?php

namespace Modules\Area\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use CodeZero\UniqueTranslation\UniqueTranslationRule;

class CountryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod())
        {
            // handle creates
            case 'post':
            case 'POST':

                return [
                  'title'         => 'required',
                  'title.*'         => 'required|unique_translation:countries,title',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title'          => 'required',
                    'title.*' => ['required', UniqueTranslationRule::for('countries', 'title')->ignore($this->country, 'id')]
                ];
        }
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

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {

          $v["title.".$key.".required"]  = __('area::dashboard.countries.validation.title.required').' - '.$value['native'].'';

          $v["title.".$key.".unique_translation"]    = __('area::dashboard.countries.validation.title.unique').' - '.$value['native'].'';

        }

        return $v;

    }
}
