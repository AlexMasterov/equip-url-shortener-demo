<?php

namespace UrlShortener\Domain\Entity;

use UrlShortener\Domain\Value\Url;
use UrlShortener\Domain\Value\Code;

class Link
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $created_at;

    /**
     * @param Url $url
     * @param string $code
     *
     * @return self
     */
    public static function create(Url $url, Code $code)
    {
        $self = new self();

        $self->id = uniqid();
        $self->url = $url->value();
        $self->code = $code->value();
        $self->created_at = date(DATE_ISO8601);

        return $self;
    }

    public function id()
    {
        return (string) $this->id;
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
