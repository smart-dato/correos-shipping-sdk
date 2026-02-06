<?php

namespace SmartDato\CorreosShipping\Exceptions;

use Exception;
use Saloon\Http\Response;

class CorreosApiException extends Exception
{
    public function __construct(
        string $message,
        int $code = 0,
        public readonly ?string $errorCode = null,
        public readonly ?string $moreInformation = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function fromResponse(Response $response): self
    {
        $data = $response->json();

        return new self(
            message: $data['message'] ?? $response->body(),
            code: $response->status(),
            errorCode: $data['code'] ?? null,
            moreInformation: $data['moreInformation'] ?? null,
        );
    }
}
