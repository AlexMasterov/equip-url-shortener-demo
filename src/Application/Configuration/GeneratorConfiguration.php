<?php

namespace UrlShortener\Application\Configuration;

use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Configuration\EnvTrait;
use UrlShortener\Domain\Generator\GeneratorInterface;
use UrlShortener\Domain\Generator\RandomBytesGenerator;

class GeneratorConfiguration implements ConfigurationInterface
{
    use EnvTrait;

    public function apply(Injector $injector)
    {
        $env = $this->env;

        $length = $env->getValue('SHORT_URL_LENGTH', 3);

        $injector->define(RandomBytesGenerator::class, [
            ':length' => $length
        ]);

        $injector->alias(
            GeneratorInterface::class,
            RandomBytesGenerator::class
        );
    }
}
