<?php

namespace UrlShortener\Domain\Repository;

use UrlShortener\Domain\Entity\Link;

interface LinkRepositoryInterface
{
    /**
     * @param Link $link
     *
     * @return void
     */
    public function add(Link $link);

    /**
     * @param string $url
     *
     * @return Link
     *
     * @throws LinksRepositoryException
     *  If a link was not found by the $url.
     */
    public function findByUrl($url);

    /**
     * @param string $code
     *
     * @return Link
     *
     * @throws LinksRepositoryException
     *  If a link was not found by the $code.
     */
    public function findByCode($code);
}
