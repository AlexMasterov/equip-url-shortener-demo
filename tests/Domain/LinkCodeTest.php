<?php

namespace UrlShortener\Tests\Domain;

use Equip\Adr\PayloadInterface;
use PHPUnit_Framework_TestCase as TestCase;
use UrlShortener\Domain\Entity\Link;
use UrlShortener\Domain\LinkCode;
use UrlShortener\Domain\Repository\LinksRepositoryInterface;
use UrlShortener\Domain\Value\Code;
use UrlShortener\Domain\Value\Url;

class LinkCodeTest extends TestCase
{
    public function testWithNoLinkCode()
    {
        $input = [];
        $output = [
            'message' => 'No link code found'
        ];
        $status = PayloadInterface::STATUS_OK;

        $repository = $this->createMock(LinksRepositoryInterface::class);

        $linkCode = new LinkCode($repository);
        $payload = $linkCode($input);

        $this->assertEquals($output, $payload->getOutput());
        $this->assertEquals($status, $payload->getStatus());
    }

    public function testWithInvalidLinkCode()
    {
        $input = [
            'linkCode' => '^'
        ];
        $output = [
            'message' => 'Value must be a valid link code'
        ];
        $status = PayloadInterface::STATUS_OK;

        $repository = $this->createMock(LinksRepositoryInterface::class);

        $linkCode = new LinkCode($repository);
        $payload = $linkCode($input);

        $this->assertEquals($output, $payload->getOutput());
        $this->assertEquals($status, $payload->getStatus());
    }

    public function testThenLinkNotExists()
    {
        $input = [
            'linkCode' => 'querty'
        ];
        $output = [
            'message' => 'No link exists'
        ];
        $status = PayloadInterface::STATUS_OK;

        $repository = $this->createMock(LinksRepositoryInterface::class);

        $linkCode = new LinkCode($repository);
        $payload = $linkCode($input);

        $this->assertEquals($output, $payload->getOutput());
        $this->assertEquals($status, $payload->getStatus());
    }

    public function testThenLinkExists()
    {
        $input = [
            'linkCode' => 'querty'
        ];
        $status = PayloadInterface::STATUS_PERMANENT_REDIRECT;

        $link = $this->createLink('http://fake.url', $input['linkCode']);
        $repository = $this->createMock(LinksRepositoryInterface::class);
        $repository
            ->expects($this->any())
            ->method('findByCode')
            ->willReturn($link);

        $linkCode = new LinkCode($repository);
        $payload = $linkCode($input);

        $this->assertEquals(
            $link->url(),
            $payload->getSetting('redirect')
        );
        $this->assertEquals($status, $payload->getStatus());
    }

    protected function createLink($url, $code)
    {
        $link = Link::create(
            new Url($url),
            new Code($code)
        );

        return $link;
    }
}
