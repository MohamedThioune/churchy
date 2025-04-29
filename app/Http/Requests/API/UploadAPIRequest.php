<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\API\ValidationForm;

class UploadAPIRequest extends FormRequest
{
    use ValidationForm;

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
            'file' => [
                'required',
                'file',
                'max:2000', // 2 MB max
                function ($attribute, $value, $fail) {
                    $forbidden = ['exe', 'php', 'sh'];
                    $extension = strtolower($value->getClientOriginalExtension());
    
                    if (in_array($extension, $forbidden)) 
                        $fail("The $attribute must not be of type: " . implode(', ', $forbidden));

                },
            ],
            'path' => 'required|string',
            'meaning' => 'required|string|in:CIN,License,Certificate,Avatar,Other',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }
}
