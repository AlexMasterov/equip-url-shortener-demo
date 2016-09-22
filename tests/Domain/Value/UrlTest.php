<?php

namespace UrlShortener\Tests\Domain\Value;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase as TestCase;
use UrlShortener\Domain\Value\Url;

class UrlTest extends TestCase
{
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

    public function dataInvalidUrls()
    {
        return [
            ['invalidUrl'],
            ['http:/invalidUrlWithScheme']
        ];
    }
}
