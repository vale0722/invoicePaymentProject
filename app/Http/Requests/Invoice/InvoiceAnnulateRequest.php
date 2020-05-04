<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceAnnulateRequest extends FormRequest
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
            'reason' => 'required|min:3|max:250'
        ];
    }

    /**
    * Get the custom attributes for validator errors
    *
    * @return array
    */
    public function attributes()
    {
        return [
            'reason' => "Motivo",
        ];
    }
}
