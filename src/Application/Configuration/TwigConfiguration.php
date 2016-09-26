<?php

namespace UrlShortener\Application\Configuration;

use AlexMasterov\TwigExtension\Psr7UriExtension;
use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Configuration\EnvTrait;
use Equip\Env;
use Twig_Environment;

class TwigConfiguration implements ConfigurationInterface
{
    use EnvTrait;

    public function apply(Injector $injector)
    {
        $injector->prepare(Twig_Environment::class, [$this, 'prepareTwig']);
    }

    /**
     * @param Twig_Environment $twig
     * @param Injector $injector
     */
    public function prepareTwig(
        Twig_Environment $twig,
        Injector $injector
    ) {
        $env = $this->env;
        $assets = $this->assets($env);

        $twig->addGlobal('assets', $assets);
        $twig->addExtension(
            $injector->make(Psr7UriExtension::class)
        );

        return $twig;
    }

    /**
     * @param Env $env
     */
    public function assets(Env $env)
    {
        $assetsPath = $env->getValue('TWIG_ASSETS_PATH', 'assets.json');
        $assets = json_decode(
            file_get_contents($assetsPath)
        );

        return $assets;
    }
}
