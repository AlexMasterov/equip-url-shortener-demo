<?php

namespace UrlShortener\Tests\Domain;

use DomainException;
use Equip\Adr\PayloadInterface;
use PHPUnit_Framework_TestCase as TestCase;
use UrlShortener\Domain\Generator\GeneratorInterface;
use UrlShortener\Domain\Repository\LinkRepositoryException;
use UrlShortener\Domain\Repository\LinkRepositoryInterface;
use UrlShortener\Domain\Shorter;

class ShorterTest extends TestCase
{
    public function testThenUrlIsMissing()
    {
        $this->setExpectedExceptionRegExp(
            DomainException::class,
            '/The URL is missing/i'
        );

        $input = [];

        $repository = $this->createMock(LinkRepositoryInterface::class);
        $generator = $this->createMock(GeneratorInterface::class);

        $shorter = new Shorter($repository, $generator);
        $shorter($input);
    }

    public function testThenLinkNotFoundByUrl()
    {
        $input = [
            'url' => 'http://fake.url'
        ];
        $output = [
            'code' => 'querty'
        ];
        $status = PayloadInterface::STATUS_OK;

        $repository = $this->createMock(LinkRepositoryInterface::class);
        $repository
            ->expects($this->any())
            ->method('findByUrl')
            ->will($this->throwException(
                LinkRepositoryException::notFound()
            ));

        $generator = $this->createMockGeneratorWithValue($output['code']);

        $shorter = new Shorter($repository, $generator);
        $payload = $shorter($input);

        $this->assertEquals($output, $payload->getOutput());
        $this->assertEquals($status, $payload->getStatus());
    }

    protected function createMockGeneratorWithValue($value)
    {
        $generator = $this->createMock(GeneratorInterface::class);
        $generator
            ->expects($this->any())
            ->method('__invoke')
            ->willReturn($value);

        return $generator;
    }
}
