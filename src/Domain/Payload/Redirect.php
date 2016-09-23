<?php

namespace UrlShortener\Domain\Payload;

use Equip\Payload;

trait Redirect
{
    /**
     * @param string $url
     *
     * @return Payload
     */
    protected function redirect($url)
    {
        return (new Payload)
            ->withSetting('redirect', $url)
            ->withStatus(Payload::STATUS_PERMANENT_REDIRECT);
    }
}
