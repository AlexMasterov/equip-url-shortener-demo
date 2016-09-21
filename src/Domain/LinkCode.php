<?php

namespace UrlShortener\Domain;

use Equip\Adr\DomainInterface;
use Equip\Adr\PayloadInterface;
use UrlShortener\Domain\AbstractDomain;
use UrlShortener\Domain\Repository\LinksRepositoryInterface;

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
        $inputCode = $input['linkCode'];

        $link = $this->repository->findByCode($inputCode);
        if (false === $link) {
            $message = 'No link exists';
            return $this->error($input, compact('message'));
        }

        $linkUrl = $link->url();

        return $this->redirect($linkUrl);
    }
}
