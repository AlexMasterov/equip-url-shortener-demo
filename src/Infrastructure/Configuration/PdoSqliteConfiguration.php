<?php

namespace UrlShortener\Infrastructure\Configuration;

use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Configuration\EnvTrait;
use Equip\Env;
use PDO;

class PdoSqliteConfiguration implements ConfigurationInterface
{
    use EnvTrait;

    private static $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_PERSISTENT         => true,
    ];

    public function apply(Injector $injector)
    {
        $dns = $this->dsn($this->env);

        $injector->define(PDO::class, [
            ':dsn'     => $dns,
            ':options' => static::$options,
        ]);
    }

    private function dsn(Env $env): string
    {
        $database = $env->getValue('PDO_SQLITE_DATABASE', 'memory');

        if ($this->isMemory($database)) {
            $database = ":{$database}:";
        }

        return "sqlite:{$database}";
    }

    private function isMemory(string $database): bool
    {
        return strtolower($database) === 'memory';
    }
}
