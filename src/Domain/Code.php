<?php

namespace UrlShortener\Domain;

use DomainException;
use Equip\Adr\DomainInterface;
use UrlShortener\Domain\Payload\NotFound;
use UrlShortener\Domain\Payload\Redirect;
use UrlShortener\Domain\Repository\LinkRepositoryException;
use UrlShortener\Domain\Repository\LinkRepositoryInterface;

class Code implements DomainInterface
{
    use NotFound;
    use Redirect;

    /**
     * @var LinkRepositoryInterface
     */
    private $repository;

    /**
     * @param LinkRepositoryInterface $repository
     */
    public function __construct(LinkRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(array $input)
    {
        if (!$this->hasCode($input)) {
            throw new DomainException('The code is missing');
        }

        $code = $input['code'];

        try {
            $link = $this->repository->findByCode($code);
        } catch (LinkRepositoryException $e) {
            $message = $e->getMessage();
            return $this->notFound($input, compact('message'));
        }

        return $this->redirect($link->url());
    }

    /**
     * @param array $input
     *
     * @return bool
     */
    private function hasCode(array $input)
    {
        return !empty($input['code']);
    }
}
