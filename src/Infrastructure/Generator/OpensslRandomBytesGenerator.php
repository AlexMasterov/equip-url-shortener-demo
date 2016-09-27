<?php

namespace UrlShortener\Infrastructure\Generator;

use UrlShortener\Domain\Generator\GeneratorInterface;

final class OpensslRandomBytesGenerator implements GeneratorInterface
{
    const ENTROPY = 64;
    const LENGTH = 3;

    /**
     * @var int
     */
    private $entropy;

    /**
     * @var int
     */
    private $length;

    /**
     * @param int $entropy
     * @param int $length
     */
    public function __construct(
        $entropy = self::ENTROPY,
        $length = self::LENGTH
    ) {
        $this->entropy = $entropy;
        $this->length = $length;
    }

    /**
     * @return string
     */
    public function __invoke()
    {
        $bytes = openssl_random_pseudo_bytes($this->entropy);
        $value = rtrim(strtr(base64_encode($bytes), '+/', '-_'), '=');

        return substr($value, 0, $this->length);
    }
}
