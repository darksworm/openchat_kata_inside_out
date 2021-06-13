<?php

namespace App\Framework\Http;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as IlluminateRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

abstract class FormRequest extends IlluminateRequest
{
    public abstract function rules(): array;

    protected function failedValidation(Validator $validator)
    {
        $response = new Response($validator->errors()->first(), 400);
        throw new ValidationException($validator, $response);
    }
}
