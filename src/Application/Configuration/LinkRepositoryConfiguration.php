<?php

namespace UrlShortener\Application\Configuration;

use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use UrlShortener\Domain\Repository\LinkRepositoryInterface;
use UrlShortener\Infrastructure\Repository\PdoLinkRepository;

class LinkRepositoryConfiguration implements ConfigurationInterface
{
    public function apply(Injector $injector)
    {
        $injector->alias(
            LinkRepositoryInterface::class,
            PdoLinkRepository::class
        );
    }
}
