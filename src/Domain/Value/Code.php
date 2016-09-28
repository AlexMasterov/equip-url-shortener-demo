<?php

namespace UrlShortener\Domain\Value;

use InvalidArgumentException;

class Code
{
    const VALID_CODE_REGEXP = '/^[?!$&\()*,;a-zA-Z0-9-._~:@]*$/';

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $options = [
            'regexp' => self::VALID_CODE_REGEXP
        ];

        if (filter_var($value, \FILTER_VALIDATE_REGEXP, compact('options')) === false) {
            throw new InvalidArgumentException('Value must be a valid code');
        }

        $this->value = $value;
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
