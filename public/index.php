<?php

require __DIR__ . '/../vendor/autoload.php';

Equip\Application::build()
->setConfiguration([
    Equip\Configuration\AurynConfiguration::class,
    Equip\Configuration\DiactorosConfiguration::class,
    Equip\Configuration\PayloadConfiguration::class,
    Equip\Configuration\RelayConfiguration::class,
    UrlShortener\Application\Configuration\EnvConfiguration::class,
    UrlShortener\Application\Configuration\GeneratorConfiguration::class,
    UrlShortener\Application\Configuration\PdoSqliteConfiguration::class,
    UrlShortener\Application\Configuration\LinksRepositoryConfiguration::class,
])
->setMiddleware([
    Relay\Middleware\ResponseSender::class,
    Equip\Handler\DispatchHandler::class,
    Equip\Handler\JsonContentHandler::class,
    Equip\Handler\FormContentHandler::class,
    Equip\Handler\ActionHandler::class,
])
->setRouting(function (Equip\Directory $directory) {
    return $directory
        ->get('/', UrlShortener\Domain\Welcome::class)
        ->post('/', UrlShortener\Domain\Shorter::class)
        ->get('/{code}', UrlShortener\Domain\Code::class)
        ->any('/{error404}', UrlShortener\Domain\Welcome::class)
        ; // End of routing
})
->run();
