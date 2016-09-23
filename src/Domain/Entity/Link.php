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
     * @param string $url
     * @param string $code
     *
     * @return self
     */
    public static function create($url, $code)
    {
        $url = new Url($url);
        $code = new Code($code);

        $self = new self();

        $self->uid = uniqid();
        $self->url = $url->value();
        $self->code = $code->value();
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
