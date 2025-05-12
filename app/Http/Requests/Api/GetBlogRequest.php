<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class GetBlogRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'categories' => 'required|string|regex:/^[a-zA-Z0-9,]+$/',
            'skip' => 'integer|min:0',
            'take' => 'integer|min:1|max:999',
        ];
    }
}
