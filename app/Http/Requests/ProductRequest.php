<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'  => 'required',
            'price'  => 'required|numeric|min:1|max:99.99',
            'image'  => 'required|image|mimes:jpeg,png,jpg,svg|max:2000',
            'status' => 'required',
        ];
    }
}
