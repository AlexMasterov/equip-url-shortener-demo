<?php

namespace UrlShortener\Domain;

use UrlShortener\Domain\AbstractDomain;

class Welcome extends AbstractDomain
{
    public function __invoke(array $input)
    {
        $message = 'Soon there will be frontend';

        return $this->render(compact('message'));
    }
}
