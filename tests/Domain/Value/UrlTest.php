<?php

namespace UrlShortener\Tests\Domain\Value;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase as TestCase;
use UrlShortener\Domain\Value\Url;

class UrlTest extends TestCase
{
    public function dataInvalidUrls()
    {
        return [
            ['invalidUrl'],
            ['http:/invalidUrlWithScheme']
        ];
    }

    /**
     * @dataProvider dataInvalidUrls
     */
    public function testThenUrlIsInvalid($value)
    {
        $this->setExpectedExceptionRegExp(
            InvalidArgumentException::class,
            '/Value must be a valid URL/i'
        );

        new Url($value);
    }

    public function testThenUrlIsValid()
    {
        $value = 'http://valid.url';
        $url = new Url($value);

        $this->assertEquals($value, $url->value());
    }
}
