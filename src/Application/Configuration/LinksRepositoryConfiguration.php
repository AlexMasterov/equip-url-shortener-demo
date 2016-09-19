<?php

namespace UrlShortener\Application\Configuration;

use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use UrlShortener\Domain\Repository\LinksRepositoryInterface;
use UrlShortener\Infrastructure\Repository\PdoLinksRepository;

class LinksRepositoryConfiguration implements ConfigurationInterface
{
    public function apply(Injector $injector)
    {
        $injector->alias(
            LinksRepositoryInterface::class,
            PdoLinksRepository::class
        );
    }
}
