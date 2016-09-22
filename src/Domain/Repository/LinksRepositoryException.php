<?php

namespace UrlShortener\Domain\Repository;

use Exception;

class LinksRepositoryException extends Exception
{
    public static function notFound()
    {
        return new static('No link exists');
    }
}
