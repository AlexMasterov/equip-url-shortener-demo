<?php

namespace UrlShortener\Domain\Repository;

use UrlShortener\Domain\Entity\Link;
use UrlShortener\Domain\Value\Code;
use UrlShortener\Domain\Value\Url;

interface LinksRepositoryInterface
{
    public function add(Link $url);
    public function findByUrl(Url $url);
    public function findByCode(Code $code);
}
