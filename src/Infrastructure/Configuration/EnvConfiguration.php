<?php

namespace UrlShortener\Infrastructure\Configuration;

use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Env;
use josegonzalez\Dotenv\Loader;

class EnvConfiguration implements ConfigurationInterface
{
    /**
     * @var string
     */
    private $rootDir;

    /**
     * @param string $rootDir
     */
    public function __construct($rootDir = null)
    {
        if (null === $rootDir) {
            $rootDir = dirname(dirname(dirname(__DIR__)));
        }

        $this->rootDir = $rootDir;
    }

    public function apply(Injector $injector)
    {
        $injector->share(Env::class);

        $injector->prepare(Env::class, [$this, 'prepareEnv']);
    }

    /**
     * @param Env $env
     *
     * @return Env
     */
    public function prepareEnv(Env $env)
    {
        $loader = $this->loader();

        $values = $loader
            ->setFilters([
                [$this, 'rootFilter']
            ])
            ->parse()
            ->filter()
            ->toArray()
            ;

        return $env->withValues($values);
    }

    /**
     * @return Loader
     */
    private function loader()
    {
        $rootDir = $this->rootDir;
        $envFile = $rootDir . DIRECTORY_SEPARATOR . '.env';

        return new Loader($envFile);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function rootFilter(array $data)
    {
        $rootDir = $this->rootDir;

        foreach ($data as $key => $value) {
            $data[$key] = str_replace('__ROOT__', $rootDir, $value);
        }

        return $data;
    }
}