<?php

namespace UrlShortener\Domain\Factory;

use DomainException;
use UrlShortener\Domain\Entity\Link;
use UrlShortener\Domain\Generator\GeneratorInterface;
use UrlShortener\Domain\Value\Code;
use UrlShortener\Domain\Value\Url;

final class LinkFactory
{
    /**
     * @var GeneratorInterface
     */
    private $generator;

    /**
     * @var array
     */
    private $blackList = [];

    /**
     * @param GeneratorInterface $generator
     */
    public function __construct(
        GeneratorInterface $generator,
        $blackList = []
    ) {
        $this->generator = $generator;
        $this->blackList = $blackList;
    }

    /**
     * @param string $url
     *
     * @return Link
     */
    public function create($url)
    {
        $url = new Url($url);

        if ($this->isBanned($url)) {
            throw new DomainException('Unable to create URL');
        }

        return Link::create(
            $url,
            new Code(
                $this->generateCode()
            )
        );
    }

    /**
     * @param Url $url
     *
     * @return bool
     */
    private function isBanned(Url $url)
    {
        return in_array($url->host(), $this->blackList);
    }

    /**
     * @return string
     */
    private function generateCode()
    {
        $generator = $this->generator;

        return $generator();
    }
}
