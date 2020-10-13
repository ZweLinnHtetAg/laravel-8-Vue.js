<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'price' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "အမည်ထည့်သွင်းရန်လိုအပ်ပါသည်",
            'name.string' => "အမည်သည် စာသားဖြစ်ရပါမည်",
            'price.required' => "စျေးနှုန်းထည့်သွင်းရန်လိုအပ်ပါသည်",
            'price.numeric' => "စျေးနှုန်းသည် ကိန်းဂဏန်းဖြစ်ရပါမည်",
        ];
    }
}
