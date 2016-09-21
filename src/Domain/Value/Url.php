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

    public function __construct($url)
    {
        $parts = parse_url($url);

        if (!isset($parts['scheme'])) {
            throw new InvalidArgumentException('Value must be a URL');
        }

        if (filter_var($url, \FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException('Value must be a valid URL');
        }

        $this->value = $url;
    }

    public function value()
    {
        return $this->value;
    }
}
