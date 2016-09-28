<?php

namespace UrlShortener\Domain;

use DomainException;
use Equip\Adr\DomainInterface;
use UrlShortener\Domain\Payload\Render;
use UrlShortener\Domain\Service\CreateLinkService;

final class Shorter implements DomainInterface
{
    use Render;

    /**
     * @var CreateLinkService
     */
    private $service;

    /**
     * @param CreateLinkService $service
     */
    public function __construct(CreateLinkService $service)
    {
        $this->service = $service;
    }

    public function __invoke(array $input)
    {
        if (!$this->hasUrl($input)) {
            throw new DomainException('The URL is missing');
        }

        $link = $this->createLink(
            $input['url']
        );

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
     * @param string $url
     *
     * @return Link
     */
    private function createLink($url)
    {
        $service = $this->service;

        return $service($url);
    }
}
