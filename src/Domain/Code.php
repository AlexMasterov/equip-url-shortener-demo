<?php

namespace UrlShortener\Domain;

use Equip\Adr\DomainInterface;
use Equip\Adr\PayloadInterface;
use UrlShortener\Domain\AbstractDomain;
use UrlShortener\Domain\Repository\LinksRepositoryInterface;

class Code extends AbstractDomain
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
        $code = $input['code'];

        $link = $this->repository->findByCode($code);
        if (false === $link) {
            $message = 'No link exist';
            return $this->error($input, compact('message'));
        }

        return $this->redirect($link->url());
    }
}
