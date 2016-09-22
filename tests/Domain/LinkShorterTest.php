<?php

namespace UrlShortener\Tests\Domain;

use Equip\Adr\PayloadInterface;
use PHPUnit_Framework_TestCase as TestCase;
use UrlShortener\Domain\Generator\GeneratorInterface;
use UrlShortener\Domain\LinkShorter;
use UrlShortener\Domain\Repository\LinksRepositoryInterface;

class LinkShorterTest extends TestCase
{
    public function testWithNoUrl()
    {
        $input = [];
        $output = [
            'message' => 'No URL found'
        ];
        $status = PayloadInterface::STATUS_OK;

        $repository = $this->createMock(LinksRepositoryInterface::class);
        $generator = $this->createMock(GeneratorInterface::class);

        $linkShorter = new LinkShorter($repository, $generator);
        $payload = $linkShorter($input);

        $this->assertEquals($output, $payload->getOutput());
        $this->assertEquals($status, $payload->getStatus());
    }

    public function testWithInvalidUrl()
    {
        $input = [
            'url' => 'invalidUrl'
        ];
        $output = [
            'message' => 'Value must be a valid URL'
        ];
        $status = PayloadInterface::STATUS_OK;

        $repository = $this->createMock(LinksRepositoryInterface::class);
        $generator = $this->createMock(GeneratorInterface::class);

        $linkShorter = new LinkShorter($repository, $generator);
        $payload = $linkShorter($input);

        $this->assertEquals($output, $payload->getOutput());
        $this->assertEquals($status, $payload->getStatus());
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
