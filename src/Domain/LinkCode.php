<?php

namespace UrlShortener\Domain;

use DomainException;
use UrlShortener\Domain\AbstractDomain;
use UrlShortener\Domain\Repository\LinksRepositoryException;
use UrlShortener\Domain\Repository\LinksRepositoryInterface;
use UrlShortener\Domain\Value\Code;

class LinkCode extends AbstractDomain
{
    /**
     * @var LinksRepositoryInterface
     */
    private $repository;

    /**
     * @param LinksRepositoryInterface $repository
     */
    public function __construct(LinksRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(array $input)
    {
        if (!$this->hasLinkCode($input)) {
            throw new DomainException('No link code found');
        }

        $linkCode = $input['linkCode'];

        try {
            $link = $this->repository->findByCode(
                new Code($linkCode)
            );
        } catch (LinksRepositoryException $e) {
            $message = $e->getMessage();
            return $this->error($input, compact('message'));
        }

        $linkUrl = $link->url();

        return $this->redirect($linkUrl);
    }

    /**
     * @param array $input
     *
     * @return bool
     */
    private function hasLinkCode(array $input)
    {
        return !empty($input['linkCode']);
    }
}
