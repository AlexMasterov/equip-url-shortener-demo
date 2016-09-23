<?php

namespace UrlShortener\Tests\Domain\Value;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase as TestCase;
use UrlShortener\Domain\Value\Code;

class CodeTest extends TestCase
{
    public function dataInvalidCodes()
    {
        return [
            ['\/'],
            ['#'],
            ['%'],
            ['+'],
            ['='],
            ['^'],
            ['<'],
            ['>'],
        ];
    }

    /**
     * @dataProvider dataInvalidCodes
     */
    public function testThenCodeIsInvalid($value)
    {
        $this->setExpectedExceptionRegExp(
            InvalidArgumentException::class,
            '/Value must be a valid code/i'
        );

        new Code($value);
    }

    public function testThenCodeIsValid()
    {
        $value = 'valid';
        $code = new Code($value);

        $this->assertEquals($value, $code->value());
    }
}
