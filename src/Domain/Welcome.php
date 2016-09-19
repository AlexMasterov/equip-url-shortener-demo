<?php

namespace UrlShortener\Domain;

use Equip\Adr\DomainInterface;
use Equip\Adr\PayloadInterface;

class Welcome implements DomainInterface
{
    /**
     * @var PayloadInterface
     */
    private $payload;

    /**
     * @param PayloadInterface $payload
     */
    public function __construct(PayloadInterface $payload)
    {
        $this->payload = $payload;
    }

    public function __invoke(array $input)
    {
        $message = 'Soon there will be frontend';

        return $this->payload
            ->withStatus(PayloadInterface::STATUS_OK)
            ->withOutput(compact('message'));
    }
}
