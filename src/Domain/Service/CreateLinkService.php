<?php

namespace UrlShortener\Domain\Service;

use UrlShortener\Domain\Factory\LinkFactory;
use UrlShortener\Domain\Repository\LinkRepositoryException;
use UrlShortener\Domain\Repository\LinkRepositoryInterface;

final class CreateLinkService
{
    /**
     * @var LinkFactory
     */
    private $factory;

    /**
     * @var LinkRepositoryInterface
     */
    private $repository;

    /**
     * @param LinkFactory $factory
     * @param LinkRepositoryInterface $repository
     */
    public function __construct(
        LinkFactory $factory,
        LinkRepositoryInterface $repository
    ) {
        $this->factory = $factory;
        $this->repository = $repository;
    }

    /**
     * @param string $url
     *
     * @return Link
     */
    public function __invoke($url)
    {
        try {
            $link = $this->repository->findByUrl($url);
        } catch (LinkRepositoryException $e) {
            $link = $this->factory->create($url);
            $this->repository->add($link);
        }

        return $link;
    }
}
