<?php

namespace UrlShortener\Tests\Domain\Generator;

use UrlShortener\Domain\Generator\GeneratorInterface;

trait MockGeneratorTrait
{
    protected function createMockGenerator($value)
    {
        $generator = $this->createMock(GeneratorInterface::class);
        $generator
            ->expects($this->any())
            ->method('__invoke')
            ->willReturn($value);

        return $generator;
    }
}
