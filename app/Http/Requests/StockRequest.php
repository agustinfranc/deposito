<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
            'rubro' => 'string|required',
            'subrubro' => 'string|nullable',
            'code' => 'required|numeric|unique:stocks,code',
            'detail' => 'required',
            'quantity' => 'numeric',
            'price' =>  'required',
            'creator_id' => 'exists:users,id',
        ];
    }
}
