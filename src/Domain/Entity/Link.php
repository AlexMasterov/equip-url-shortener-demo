<?php

namespace UrlShortener\Domain\Entity;

use UrlShortener\Domain\Value\Code;
use UrlShortener\Domain\Value\Url;

class Link
{
    /**
     * @var string
     */
    private $uid;

    /**
     * @var Url
     */
    private $url;

    /**
     * @var Code
     */
    private $code;

    /**
     * @var string
     */
    private $created_at;

    /**
     * @param Url $url
     * @param Code $code
     *
     * @return self
     */
    public static function create(Url $url, Code $code)
    {
        $self = new self();

        $self->uid = uniqid();
        $self->url = (string) $url;
        $self->code = (string) $code;
        $self->created_at = date(DATE_ISO8601);

        return $self;
    }

    public function uid()
    {
        return (string) $this->uid;
    }

    public function url()
    {
        return $this->url;
    }

    public function code()
    {
        return $this->code;
    }

    public function createdAt()
    {
        return $this->created_at;
    }
}
