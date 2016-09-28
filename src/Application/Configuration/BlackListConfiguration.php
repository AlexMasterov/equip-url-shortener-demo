<?php

namespace UrlShortener\Application\Configuration;

use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Configuration\EnvTrait;
use Equip\Env;
use Psr\Http\Message\ServerRequestInterface;
use UrlShortener\Domain\Factory\LinkFactory;

class BlackListConfiguration implements ConfigurationInterface
{
    use EnvTrait;

    public function apply(Injector $injector)
    {
        $env = $this->env;

        $blackList = $this->blackList($env);

        $key = array_search('self', $blackList);
        if (false !== $key) {
            $blackList[$key] = $injector->execute([$this, 'selfHost']);
        }

        $injector->define(LinkFactory::class, [
            ':blackList' => $blackList
        ]);
    }

    /**
     * @param Env $env
     *
     * @return array
     */
    public function blackList(Env $env)
    {
        $blackList = $env->getValue('SHORT_URL_BLACKLIST_HOSTS', 'self');
        $blackList = array_map('trim', explode(',', $blackList));

        return $blackList;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return string
     */
    public function selfHost(ServerRequestInterface $request)
    {
        $host = $request->getUri()->getHost();

        return $host;
    }
}
