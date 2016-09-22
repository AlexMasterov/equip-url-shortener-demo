<?php

namespace UrlShortener\Domain;

use Equip\Adr\DomainInterface;
use Equip\Adr\PayloadInterface;
use InvalidArgumentException;
use UrlShortener\Domain\AbstractDomain;
use UrlShortener\Domain\Entity\Link;
use UrlShortener\Domain\Generator\GeneratorInterface;
use UrlShortener\Domain\Repository\LinksRepositoryInterface;
use UrlShortener\Domain\Value\Code;
use UrlShortener\Domain\Value\Url;

class LinkShorter extends AbstractDomain
{
    /**
     * @var LinksRepositoryInterface
     */
    private $repository;

    /**
     * @var GeneratorInterface
     */
    private $generator;

    /**
     * @param LinksRepositoryInterface $repository
     */
    public function __construct(
        LinksRepositoryInterface $repository,
        GeneratorInterface $generator
    ) {
        $this->repository = $repository;
        $this->generator = $generator;
    }

    public function __invoke(array $input)
    {
        if (!$this->hasUrl($input)) {
            $message = 'No URL found';
            return $this->error($input, compact('message'));
        }

        $url = $input['url'];

        $link = $this->repository->findByUrl(
            new Url($url)
        );

        if (!$link) {
            $code = $this->generator();
            $link = $this->createLink($url, $code);

            $this->repository->add($link);
        }

        $linkCode = $link->code();

        return $this->payload()
            ->withStatus(PayloadInterface::STATUS_OK)
            ->withOutput(compact('linkCode'));
    }

    /**
     * @param array $input
     *
     * @return bool
     */
    private function hasUrl(array $input)
    {
        return !empty($input['url']);
    }

    /**
     * @return string
     */
    private function generator()
    {
        $generator = $this->generator;

        return $generator();
    }

    /**
     * @param string $url
     * @param string $code
     *
     * @return Link
     */
    private function createLink($url, $code)
    {
        $link = Link::create(
            new Url($url),
            new Code($code)
        );

        return $link;
    }
}
