<?php

namespace UrlShortener\Tests\Domain;

use DomainException;
use Equip\Adr\PayloadInterface;
use PHPUnit_Framework_TestCase as TestCase;
use UrlShortener\Domain\Factory\LinkFactory;
use UrlShortener\Domain\Repository\LinkRepositoryException;
use UrlShortener\Domain\Repository\LinkRepositoryInterface;
use UrlShortener\Domain\Service\CreateLinkService;
use UrlShortener\Domain\Shorter;
use UrlShortener\Tests\Domain\Generator\MockGeneratorTrait;

class ShorterTest extends TestCase
{
    use MockGeneratorTrait;

    public function testThenUrlIsMissing()
    {
        $this->setExpectedExceptionRegExp(
            DomainException::class,
            '/The URL is missing/i'
        );

        $input = [];

        $generator = $this->createMockGenerator('123');
        $factory = new LinkFactory($generator);

        $repository = $this->createMock(LinkRepositoryInterface::class);
        $service = new CreateLinkService($factory, $repository);

        $shorter = new Shorter($service);
        $shorter($input);
    }

    public function testThenUrlIsValid()
    {
        $input = ['url' => 'http://valid.url'];
        $code = 'querty';

        $generator = $this->createMockGenerator($code);
        $factory = new LinkFactory($generator);

        $repository = $this->createMock(LinkRepositoryInterface::class);
        $repository
            ->expects($this->any())
            ->method('findByUrl')
            ->will($this->throwException(
                LinkRepositoryException::notFound()
            ));

        $service = new CreateLinkService($factory, $repository);

        $shorter = new Shorter($service);
        $payload = $shorter($input);

        $this->assertEquals(compact('code'), $payload->getOutput());
        $this->assertEquals(
            PayloadInterface::STATUS_OK,
            $payload->getStatus()
        );
    }
}
