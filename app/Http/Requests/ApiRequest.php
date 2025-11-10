<?php

namespace App\Http\Requests;

use App\Exceptions\App\AppValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class ApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function wantsJson(): bool
    {
        return true;
    }

    public function expectsJson(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator): void
    {
        throw AppValidationException::fromValidator($validator);
    }
} 
