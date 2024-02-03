<?php

namespace App\Http\Requests;

class GetCurrenciesConvertRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'to_currency_id' => 'required|exists:currencies,id,default,0,deleted_at,NULL',
            'amount' => 'required|decimal:0,2|min:0.01',
        ];
    }
}
