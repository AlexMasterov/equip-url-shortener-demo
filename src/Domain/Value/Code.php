<?php

namespace UrlShortener\Domain\Value;

use InvalidArgumentException;

class Code
{
    /**
     * @var string
     */
    private $value;

    public function __construct($value)
    {
        $options = [
            'options' => [
                'regexp' => '/^[?%!$&\'()*+,;=a-zA-Z0-9-._~:@\/]*$/'
            ]
        ];

        if (filter_var($value, \FILTER_VALIDATE_REGEXP, $options) === false) {
            throw new InvalidArgumentException('Value must be a valid link code');
        }

        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}
