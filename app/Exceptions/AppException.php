<?php

namespace App\Exceptions;


/**
 * Базовый класс для всех исключений приложения.
 * Наследуется от \Exception, предоставляет единый контракт
 * с доменным кодом ошибки и пользовательским сообщением.
 */
abstract class AppException extends \Exception
{
    protected mixed $data = null;

    public function __construct(
        ?string $message = null, 
        mixed $data = null, 
        ?\Throwable $previous = null,
    )
    {
        $this->data = $data;
        parent::__construct($message ?? 'Неизвестная ошибка', 0, $previous);
    }

    /**
     * Доменный код ошибки (например, validation_error, not_found и т.д.).
     */
    abstract public function getDomainCode(): string;

    /**
     * HTTP код ошибки для ответа.
     */
    abstract public function getHttpStatusCode(): int;

    public function __toString(): string
    {
        return sprintf('[%s] %s in %s:%d', $this->getDomainCode(), $this->getMessage(), $this->getFile(), $this->getLine());
    }

    public function getData(): mixed
    {
        return $this->data;
    }
}
