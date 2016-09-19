<?php

namespace UrlShortener\Domain;

use Equip\Adr\DomainInterface;
use Equip\Payload;

abstract class AbstractDomain implements DomainInterface
{
    /**
     * @return Payload
     */
    protected function payload()
    {
        return new Payload;
    }

    /**
     * @param string $url
     *
     * @return Payload
     */
    protected function redirect($url)
    {
        return $this->payload()
            ->withStatus(Payload::STATUS_PERMANENT_REDIRECT)
            ->withSetting('redirect', $url);
    }

    /**
     * @param array $input
     * @param array $messages
     *
     * @return Payload
     */
    protected function error(array $input, array $messages = [])
    {
        return $this->payload()
            ->withStatus(Payload::STATUS_OK)
            ->withInput($input)
            ->withOutput($messages);
    }

}
