<?php

namespace UrlShortener\Infrastructure\Generator;

use UrlShortener\Domain\Generator\GeneratorInterface;

final class RandomBytesGenerator implements GeneratorInterface
{
    /**
     * @var int
     */
    private $entropy;

    /**
     * @var int
     */
    private $length;

    public function __construct(
        int $entropy = GeneratorInterface::ENTROPY,
        int $length = GeneratorInterface::LENGTH
    ) {
        $this->entropy = $entropy;
        $this->length = $length;
    }

    public function __invoke(): string
    {
        $bytes = random_bytes($this->entropy);
        $value = rtrim(strtr(base64_encode($bytes), '+/', '-_'), '=');

        return substr($value, 0, $this->length);
    }
}
