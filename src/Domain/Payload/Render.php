<?php

namespace UrlShortener\Domain\Payload;

use Equip\Payload;

trait Render
{
    /**
     * @param string $template
     * @param array $output
     *
     * @return Payload
     */
    protected function render($template, array $output = [])
    {
        return (new Payload)
            ->withSetting('template', $template)
            ->withStatus(Payload::STATUS_OK)
            ->withOutput($output);
    }
}
