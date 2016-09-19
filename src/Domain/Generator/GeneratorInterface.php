<?php

namespace UrlShortener\Domain\Generator;

interface GeneratorInterface
{
    /**
     * @return string
     */
    public function __invoke();
}
