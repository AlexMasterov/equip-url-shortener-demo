<?php

namespace UrlShortener\Domain\Repository;

use Exception;

class LinkRepositoryException extends Exception
{
    /**
     * @return static
     */
    public static function notFound()
    {
        return new static('Link not found');
    }
}
