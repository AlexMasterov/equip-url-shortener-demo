<?php

namespace UrlShortener\Tests\Domain;

use DomainException;
use Equip\Adr\PayloadInterface;
use PHPUnit_Framework_TestCase as TestCase;
use UrlShortener\Domain\Code;
use UrlShortener\Domain\Factory\LinkFactory;
use UrlShortener\Domain\Repository\LinkRepositoryException;
use UrlShortener\Domain\Repository\LinkRepositoryInterface;
use UrlShortener\Domain\Generator\GeneratorInterface;

class CodeTest extends TestCase
{
    public function testThenCodeIsMissing()
    {
        $this->setExpectedExceptionRegExp(
            DomainException::class,
            '/The code is missing/i'
        );

        $input = [];

        $repository = $this->createMock(LinkRepositoryInterface::class);

        $code = new Code($repository);
        $code($input);
    }

    public function testThenLinkNotFoundByCode()
    {
        $input = [
            'code' => 'querty'
        ];
        $output = [
            'message' => 'Link not found'
        ];
        $status = PayloadInterface::STATUS_NOT_FOUND;

        $repository = $this->createMock(LinkRepositoryInterface::class);
        $repository
            ->expects($this->any())
            ->method('findByCode')
            ->will($this->throwException(
                LinkRepositoryException::notFound()
            ));

        $code = new Code($repository);
        $payload = $code($input);

        $this->assertEquals($output, $payload->getOutput());
        $this->assertEquals($status, $payload->getStatus());
    }

    public function testThenLinkFoundByCode()
    {
        $input = [
            'code' => 'querty'
        ];

        $status = PayloadInterface::STATUS_PERMANENT_REDIRECT;

        $generator = $this->createMock(GeneratorInterface::class);
        $generator
            ->expects($this->any())
            ->method('__invoke')
            ->willReturn('querty');

        $factory = new LinkFactory($generator);

        $link = $factory->create('http://link.url');
        $url = $link->url();

        $repository = $this->createMock(LinkRepositoryInterface::class);
        $repository
            ->expects($this->any())
            ->method('findByCode')
            ->willReturn($link);

        $code = new Code($repository);
        $payload = $code($input);

        $this->assertEquals($url, $payload->getSetting('redirect'));
        $this->assertEquals($status, $payload->getStatus());
    }
}
