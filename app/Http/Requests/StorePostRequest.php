<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "location" => ["required", "string", "max:255"],
            "description" => ["string", "max:1000"],
            "picture" => 'required|image|mimes:jpeg,jpg,png,webp|max:1024|dimensions:min_width=100,min_height=100,max_width=3000,max_height=3000'
        ];
    }
}
