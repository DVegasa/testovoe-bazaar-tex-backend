<?php

namespace App\Exceptions\App;

use App\Exceptions\AppException;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;

class AppValidationException extends AppException
{
    /**
     * @var array<string, array<int, string>>
     */
    protected array $errors;

    public function __construct(
        ?string $message = null, 
        mixed $data = null, 
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $data, $previous);
    }

    public static function fromValidator(Validator $validator): self
    {
        $errorsBag = $validator->errors();
        $fields = $errorsBag->toArray();

        return new self(
            'Ошибка валидации',
            $fields,
        );
    }

    public function getDomainCode(): string
    {
        return 'validation_error';
    }

    public function getHttpStatusCode(): int
    {
        return JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
    }
}
