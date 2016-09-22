<?php

namespace UrlShortener\Domain\Generator;

use UrlShortener\Domain\Generator\GeneratorInterface;

class RandomBytesGenerator implements GeneratorInterface
{
    const DEFAULT_LENGTH = 3;
    const DEFAULT_ENTROPY = 256;

    /**
     * @var int
     */
    private $length;

    /**
     * @var int
     */
    private $entropy;

    /**
     * @param int $length
     * @param int $entropy
     */
    public function __construct(
        $length = self::DEFAULT_LENGTH,
        $entropy = self::DEFAULT_ENTROPY
    ) {
        $this->length = $length;
        $this->entropy = $entropy;
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
