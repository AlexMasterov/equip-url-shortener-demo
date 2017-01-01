<?php

namespace UrlShortener\Domain\Generator;

interface GeneratorInterface
{
    const ENTROPY = 64;
    const LENGTH = 3;

    public function __invoke(): string;
}
