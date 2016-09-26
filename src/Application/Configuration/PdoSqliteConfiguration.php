<?php

namespace UrlShortener\Application\Configuration;

use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Configuration\EnvTrait;
use Equip\Env;
use PDO;

class PdoSqliteConfiguration implements ConfigurationInterface
{
    use EnvTrait;

    public function apply(Injector $injector)
    {
        $env = $this->env;

        list($database, $options) = $this->configFromEnv($env);

        $injector->define(PDO::class, [
            ':dsn'     => "sqlite:{$database}",
            ':options' => $options,
        ]);
    }

    /**
     * @param Env $env
     *
     * @return array
     */
    private function configFromEnv(Env $env)
    {
        $database = $env->getValue('PDO_SQLITE_DATABASE', 'memory');

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        if ($this->isMemory($database)) {
            $database = ":${database}:";
            $options += [PDO::ATTR_PERSISTENT => true];
        }

        return [$database, $options];
    }

    /**
     * @param string $database
     *
     * @return bool
     */
    private function isMemory($database)
    {
        return strtolower($database) === 'memory';
    }
}
