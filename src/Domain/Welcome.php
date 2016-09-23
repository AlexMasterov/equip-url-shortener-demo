<?php

namespace UrlShortener\Domain;

use Equip\Adr\DomainInterface;
use UrlShortener\Domain\Payload\Render;

class Welcome implements DomainInterface
{
    use Render;

    public function __invoke(array $input)
    {
        $title = 'URL Shortener Demo';

        return $this->render('index', compact('title'));
    }
}
