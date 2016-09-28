<?php

namespace UrlShortener\Tests\Domain;

use DomainException;
use PHPUnit_Framework_TestCase as TestCase;
use UrlShortener\Domain\Factory\LinkFactory;
use UrlShortener\Tests\Domain\Generator\MockGeneratorTrait;

class LinkFactoryTest extends TestCase
{
    use MockGeneratorTrait;

    public function testThenUrlIsValid()
    {
        $url = 'http://valid.url';
        $code = '123';

        $generator = $this->createMockGenerator($code);
        $factory = new LinkFactory($generator);

        $link = $factory->create($url);

        $this->assertEquals($url, $link->url());
        $this->assertEquals($code, $link->code());
    }

    public function testThenUrlIsBanned()
    {
        $this->setExpectedExceptionRegExp(
            DomainException::class,
            '/Unable to create URL/i'
        );

        $bannedHost = [
            'banned.url'
        ];

        $url = 'http://banned.url';
        $code = '123';

        $generator = $this->createMockGenerator($code);
        $factory = new LinkFactory($generator, $bannedHost);

        $factory->create($url);
    }
}
