<?php

namespace UrlShortener\Domain;

use Equip\Adr\DomainInterface;
use Equip\Adr\PayloadInterface;
use InvalidArgumentException;
use UrlShortener\Domain\AbstractDomain;
use UrlShortener\Domain\Entity\Link;
use UrlShortener\Domain\Generator\GeneratorInterface;
use UrlShortener\Domain\Repository\LinksRepositoryInterface;
use UrlShortener\Domain\Value\Url;

class Shorter extends AbstractDomain
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

        $inputUrl = $input['url'];

        try {
            $url = new Url($inputUrl);
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
            return $this->error($input, compact('message'));
        }

        $link = $this->repository->findByUrl($url);
        if (!$link) {
            $link = $this->createLink($url);
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
     * @param Url $url
     *
     * @return Link
     */
    private function createLink(Url $url)
    {
        $code = $this->generateCode();

        return Link::create($url, $code);
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
