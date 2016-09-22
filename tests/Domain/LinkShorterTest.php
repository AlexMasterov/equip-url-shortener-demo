<?php

namespace UrlShortener\Tests\Domain;

use DomainException;
use Equip\Adr\PayloadInterface;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase as TestCase;
use UrlShortener\Domain\Generator\GeneratorInterface;
use UrlShortener\Domain\LinkShorter;
use UrlShortener\Domain\Repository\LinksRepositoryException;
use UrlShortener\Domain\Repository\LinksRepositoryInterface;

class LinkShorterTest extends TestCase
{
    public function testWithNoUrl()
    {
        $this->setExpectedExceptionRegExp(
            DomainException::class,
            '/No URL found/i'
        );

        $input = [];

        $repository = $this->createMock(LinksRepositoryInterface::class);
        $generator = $this->createMock(GeneratorInterface::class);

        $linkShorter = new LinkShorter($repository, $generator);
        $linkShorter($input);
    }

    public function testWithInvalidUrl()
    {
        $this->setExpectedExceptionRegExp(
            InvalidArgumentException::class,
            '/Value must be a valid URL/i'
        );

        $input = [
            'url' => 'invalidUrl'
        ];

        $repository = $this->createMock(LinksRepositoryInterface::class);
        $generator = $this->createMock(GeneratorInterface::class);

        $linkShorter = new LinkShorter($repository, $generator);
        $linkShorter($input);
    }

    public function testThenUrlNotExists()
    {
        $input = [
            'url' => 'http://fake.url'
        ];
        $output = [
            'linkCode' => 'querty'
        ];
        $status = PayloadInterface::STATUS_OK;

        $repository = $this->createMock(LinksRepositoryInterface::class);
        $repository
            ->expects($this->any())
            ->method('findByUrl')
            ->will($this->throwException(
                LinksRepositoryException::notFound()
            ));

        $generator = $this->createMockGeneratorWithValue($output['linkCode']);

        $linkShorter = new LinkShorter($repository, $generator);
        $payload = $linkShorter($input);

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
