<?php

namespace UrlShortener\Domain\Generator;

use UrlShortener\Domain\Generator\GeneratorInterface;

class RandomBytesGenerator implements GeneratorInterface
{
    /**
     * @var integer
     */
    private $length;

    /**
     * @param integer $length
     */
    public function __construct($length)
    {
        $this->length = $length;
    }

    /**
     * @return string
     */
    public function __invoke()
    {
        $bytes = random_bytes($this->length);

        return rtrim(strtr(base64_encode($bytes), '+/', '-_'), '=');
    }
}
