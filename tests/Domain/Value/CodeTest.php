<?php

namespace UrlShortener\Tests\Domain\Value;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase as TestCase;
use UrlShortener\Domain\Value\Code;

class CodeTest extends TestCase
{
    public function testThenCodeIsInvalid()
    {
        $this->setExpectedExceptionRegExp(
            InvalidArgumentException::class,
            '/Value must be a valid link code/i'
        );

        $value = '^';

        new Code($value);
    }

    public function testThenCodeIsValid()
    {
        $value = 'valid';
        $code = new Code($value);

        $this->assertEquals($value, $code->value());
    }
}
