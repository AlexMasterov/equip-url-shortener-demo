<?php

namespace UrlShortener\Domain;

use DomainException;
use Equip\Adr\DomainInterface;
use UrlShortener\Domain\Entity\Link;
use UrlShortener\Domain\Generator\GeneratorInterface;
use UrlShortener\Domain\Payload\NotFound;
use UrlShortener\Domain\Payload\Render;
use UrlShortener\Domain\Repository\LinkRepositoryException;
use UrlShortener\Domain\Repository\LinkRepositoryInterface;

final class Shorter implements DomainInterface
{
    use NotFound;
    use Render;

    /**
     * @var LinkRepositoryInterface
     */
    private $repository;

    /**
     * @var GeneratorInterface
     */
    private $generator;

    /**
     * @param LinkRepositoryInterface $repository
     */
    public function __construct(
        LinkRepositoryInterface $repository,
        GeneratorInterface $generator
    ) {
        $this->repository = $repository;
        $this->generator = $generator;
    }

    public function __invoke(array $input)
    {
        if (!$this->hasUrl($input)) {
            throw new DomainException('The URL is missing');
        }

        $url = $input['url'];

        try {
            $link = $this->repository->findByUrl($url);
        } catch (LinkRepositoryException $e) {
            $code = $this->generateCode();
            $link = Link::create($url, $code);

            $this->repository->add($link);
        }

        $code = $link->code();

        return $this->render('index', compact('code'));
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
    private function generateCode()
    {
        $generator = $this->generator;

        return $generator();
    }
}
