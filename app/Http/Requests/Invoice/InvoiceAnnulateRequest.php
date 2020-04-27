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
            'reason' => 'required|min:3'
        ];
    }

    /**
     * Get the custom messages for validator errors
     *
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'required' => "El :attribute es un campo obligadorio",
        ];
    }
    
    /**
    * Get the custom attributes for validator errors
    *
    * @return array
    */
    public function customValidationAttributes()
    {
        return [
            'reason' => "Motivo",
        ];
    }
}
