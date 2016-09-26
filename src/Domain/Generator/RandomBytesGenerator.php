<?php

namespace UrlShortener\Domain\Generator;

use UrlShortener\Domain\Generator\GeneratorInterface;

final class RandomBytesGenerator implements GeneratorInterface
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
        $bytes = random_bytes($this->entropy);
        $value = rtrim(strtr(base64_encode($bytes), '+/', '-_'), '=');

        return substr($value, 0, $this->length);
    }
}
