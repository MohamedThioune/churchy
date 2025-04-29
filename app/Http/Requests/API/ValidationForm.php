<?php

namespace App\Http\Requests\API;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

trait ValidationForm {

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([

                'success'   => false,

                'message'   => 'Validation errors',

                'errors'      => $validator->errors()

            ], 422)
        );
    }

    public function messages()
    {
        return [

            'title.required' => 'Title is required',

            'body.required' => 'Body is required'

        ];
    }

}