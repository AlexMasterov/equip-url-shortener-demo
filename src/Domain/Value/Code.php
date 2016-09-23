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

    public function __construct($value)
    {
        $options = [
            'options' => [
                'regexp' => self::VALID_CODE_REGEXP
            ]
        ];

        if (filter_var($value, \FILTER_VALIDATE_REGEXP, $options) === false) {
            throw new InvalidArgumentException('Value must be a valid code');
        }

        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}
