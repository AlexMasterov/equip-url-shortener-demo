<?php

namespace UrlShortener\Domain\Value;

use InvalidArgumentException;
use UrlShortener\Domain\Value\Url;

class Url
{
    /**
     * @var string|null
     */
    private $url;

    public function __construct($url)
    {
        static $emptyValues = [null, ''];

        if (in_array($url, $emptyValues, true)) {
            $url = null;
        } else {
            $parts = parse_url($url);
            if (!isset($parts['scheme'])) {
                throw new InvalidArgumentException('Value must be a URL');
            }

            if (false === filter_var($url, \FILTER_VALIDATE_URL)) {
                throw new InvalidArgumentException('Value must be a valid URL');
            }
        }

        $this->value = $url;
    }

    public function value()
    {
        return $this->value;
    }
}
