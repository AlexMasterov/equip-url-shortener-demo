<?php

namespace UrlShortener\Application\Configuration;

use AlexMasterov\EquipTwig\Configuration\TwigResponderConfiguration;
use Equip\Configuration\ConfigurationSet;
use UrlShortener\Application\Configuration\BlackListConfiguration;
use UrlShortener\Application\Configuration\EnvConfiguration;
use UrlShortener\Application\Configuration\GeneratorConfiguration;
use UrlShortener\Application\Configuration\LinkRepositoryConfiguration;
use UrlShortener\Application\Configuration\PdoSqliteConfiguration;
use UrlShortener\Application\Configuration\TwigConfiguration;

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
