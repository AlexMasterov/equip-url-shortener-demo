<?php

namespace UrlShortener\Domain;

use Equip\Adr\DomainInterface;
use Equip\Adr\PayloadInterface;
use InvalidArgumentException;
use UrlShortener\Domain\AbstractDomain;
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
            $message = 'No link code found';
            return $this->error($input, compact('message'));
        }

        $inputCode = $input['linkCode'];

        try {
            $code = new Code($inputCode);
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
            return $this->error($input, compact('message'));
        }

        $link = $this->repository->findByCode($code);
        if (null === $link) {
            $message = 'No link exists';
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
