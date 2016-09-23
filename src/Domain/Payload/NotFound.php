<?php

namespace UrlShortener\Domain\Payload;

use Equip\Payload;

trait NotFound
{
    /**
     * @param array $input
     * @param array $messages
     *
     * @return Payload
     */
    protected function notFound(array $input, array $messages = [])
    {
        return (new Payload)
            ->withSetting('template', 'codes/404')
            ->withStatus(Payload::STATUS_NOT_FOUND)
            ->withInput($input)
            ->withOutput($messages);
    }
}
