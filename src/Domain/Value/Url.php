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

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $scheme = parse_url($value, PHP_URL_SCHEME);

        if (!isset($scheme)) {
            throw new InvalidArgumentException('Value must be a valid URL');
        }

        $this->value = $value;
    }

    public function host()
    {
        $host = parse_url($this->value, PHP_URL_HOST);

        return $host;
    }

    public function value()
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
