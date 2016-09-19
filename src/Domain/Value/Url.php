<?php

namespace UrlShortener\Domain\Value;

use InvalidArgumentException;
use UrlShortener\Domain\Value\Url;

class Url
{
    /**
     * @var string|null
     */
    private $value;

    public function __construct($value)
    {
        static $emptyValues = [null, ''];

        if (in_array($value, $emptyValues, true)) {
            $number = null;
        } else {
            $parts = parse_url($value);
            if (!isset($parts['scheme'])) {
                throw new InvalidArgumentException('Value must be a URL');
            }

            if (false === filter_var($value, \FILTER_VALIDATE_URL)) {
                throw new InvalidArgumentException('Value must be a valid URL');
            }
        }

        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}
