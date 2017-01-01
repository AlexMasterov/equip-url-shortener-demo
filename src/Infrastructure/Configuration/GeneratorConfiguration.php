<?php

namespace UrlShortener\Infrastructure\Configuration;

use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Configuration\EnvTrait;
use Equip\Env;
use RuntimeException;
use UrlShortener\Domain\Generator\GeneratorInterface;
use UrlShortener\Infrastructure\Generator\OpensslRandomBytesGenerator;
use UrlShortener\Infrastructure\Generator\RandomBytesGenerator;

class GeneratorConfiguration implements ConfigurationInterface
{
    use EnvTrait;

    private static $generators = [
        'random_bytes'         => RandomBytesGenerator::class,
        'openssl_random_bytes' => OpensslRandomBytesGenerator::class,
    ];

    public function apply(Injector $injector)
    {
        $env = $this->env;

        $generator = $this->generator($env);
        $options = $this->options($env);

        if (!empty($options)) {
            $injector->define($generator, $options);
        }

        $injector->alias(GeneratorInterface::class, $generator);
    }

    private function generator(Env $env): string
    {
        $generator = $env->getValue('SHORT_URL_GENERATOR', 'random_bytes');

        if (isset(static::$generators[$generator])) {
            return static::$generators[$generator];
        }

        throw new RuntimeException(sprintf(
            'Generator `%s` could not be found and loaded.',
            $generator
        ));
    }

    private function options(Env $env): array
    {
        $options = [
            ':entropy' => $env->getValue('SHORT_URL_GENERATOR_ENTROPY'),
            ':length' => $env->getValue('SHORT_URL_GENERATOR_LENGTH'),
        ];

        return array_filter($options);
    }
}
