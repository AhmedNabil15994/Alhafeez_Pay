<?php

namespace Modules\Invoice\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
                    'reference_no' => 'required',
                    'amount' => 'required|numeric',
                    'mobile' => 'required|numeric',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'reference_no' => 'required',
                    'amount' => 'required|numeric',
                    'mobile' => 'required|numeric',
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
        return
        [
            'reference_no.required' => __('invoice::dashboard.validation.reference_no_required'),
            'amount.required' => __('invoice::dashboard.validation.amount_required'),
            'amount.numeric' => __('invoice::dashboard.validation.amount_not_numeric'),
            'mobile.required' => __('invoice::dashboard.validation.mobile_required'),
        ];
    }
}
