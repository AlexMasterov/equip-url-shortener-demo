<?php

namespace UrlShortener\Infrastructure\Configuration;

use AlexMasterov\EquipTwig\Configuration\TwigResponderConfiguration;
use Equip\Configuration\ConfigurationSet;
use UrlShortener\Infrastructure\Configuration\BlackListConfiguration;
use UrlShortener\Infrastructure\Configuration\EnvConfiguration;
use UrlShortener\Infrastructure\Configuration\GeneratorConfiguration;
use UrlShortener\Infrastructure\Configuration\LinkRepositoryConfiguration;
use UrlShortener\Infrastructure\Configuration\PdoSqliteConfiguration;
use UrlShortener\Infrastructure\Configuration\TwigConfiguration;

class UrlShortenerConfigurationSet extends ConfigurationSet
{
    public function __construct()
    {
        parent::__construct([
            EnvConfiguration::class,
            GeneratorConfiguration::class,
            BlackListConfiguration::class,
            PdoSqliteConfiguration::class,
            LinkRepositoryConfiguration::class,
            TwigResponderConfiguration::class,
            TwigConfiguration::class,
        ]);
    }
}
