<?php

namespace UrlShortener\Domain\Value;

use InvalidArgumentException;
use UrlShortener\Domain\Value\Url;

class Url
{
    /**
     * @var string
     */
    private $value;

    public function __construct($value)
    {
        $parts = parse_url($value);

        if (!isset($parts['scheme'])) {
            throw new InvalidArgumentException('Value must be a valid URL');
        }

        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}
