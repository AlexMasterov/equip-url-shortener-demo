<?php

namespace UrlShortener\Application\Configuration;

use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Configuration\EnvTrait;
use Equip\Env;
use UrlShortener\Domain\Generator\GeneratorInterface;
use UrlShortener\Infrastructure\Generator\OpensslRandomBytesGenerator;
use UrlShortener\Infrastructure\Generator\RandomBytesGenerator;

class GeneratorConfiguration implements ConfigurationInterface
{
    use EnvTrait;

    /**
     * @var array
     */
    private $generators = [
        'random_bytes'         => RandomBytesGenerator::class,
        'openssl_random_bytes' => OpensslRandomBytesGenerator::class,
    ];

    public function apply(Injector $injector)
    {
        $env = $this->env;

        $generator = $this->generator($env);

        $entropy = $env->getValue('SHORT_URL_GENERATOR_ENTROPY', $generator::ENTROPY);
        $length = $env->getValue('SHORT_URL_GENERATOR_LENGTH', $generator::LENGTH);

        $injector->define($generator, [
            ':entropy' => $entropy,
            ':length' => $length
        ]);

        $injector->alias(
            GeneratorInterface::class,
            $generator
        );
    }

    /**
     * @param Env $env
     *
     * @return string
     */
    private function generator(Env $env)
    {
        $generator = $env->getValue('SHORT_URL_GENERATOR', 'random_bytes');

        if ($this->hasGenerator($generator)) {
            return $this->generators[$generator];
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    private function hasGenerator($name)
    {
        return isset($this->generators[$name])
            && is_subclass_of($this->generators[$name], GeneratorInterface::class);
    }
}
