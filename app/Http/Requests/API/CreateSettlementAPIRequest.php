<?php

namespace App\Http\Requests\API;

use App\Models\Settlement;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\API\ValidationForm;

class CreateSettlementAPIRequest extends FormRequest
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
        $rules = Settlement::$rules;
        
        return $rules;

    }
}
