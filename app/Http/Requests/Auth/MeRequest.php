<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiRequest;

class MeRequest extends ApiRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
