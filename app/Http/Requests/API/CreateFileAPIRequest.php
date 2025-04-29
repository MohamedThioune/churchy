<?php

namespace App\Http\Requests\API;

use App\Models\File;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\API\ValidationForm;

class CreateFileAPIRequest extends APIRequest
{
    use ValidationForm;

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
        return File::$rules;
    }
}
