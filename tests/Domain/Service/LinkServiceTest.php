<?php

namespace UrlShortener\Tests\Service;

use PHPUnit_Framework_TestCase as TestCase;
use UrlShortener\Domain\Entity\Link;
use UrlShortener\Domain\Factory\LinkFactory;
use UrlShortener\Domain\Repository\LinkRepositoryException;
use UrlShortener\Domain\Repository\LinkRepositoryInterface;
use UrlShortener\Domain\Service\CreateLinkService;
use UrlShortener\Tests\Domain\Generator\MockGeneratorTrait;

class LinkServiceTest extends TestCase
{
    use MockGeneratorTrait;

    public function testCreateLink()
    {
        $url = 'http://valid.url';

        $generator = $this->createMockGenerator('123');
        $factory = new LinkFactory($generator);

        $repository = $this->createMock(LinkRepositoryInterface::class);
        $repository
            ->expects($this->any())
            ->method('findByUrl')
            ->will($this->throwException(
                LinkRepositoryException::notFound()
            ));

        $service = new CreateLinkService($factory, $repository);
        $link = $service($url);

        $this->assertInstanceOf(Link::class, $link);
        $this->assertEquals($url, $link->url());
    }
}
