<?php

namespace UrlShortener\Infrastructure\Repository;

use PDO;
use UrlShortener\Domain\Entity\Link;
use UrlShortener\Domain\Repository\LinkRepositoryException;
use UrlShortener\Domain\Repository\LinkRepositoryInterface;

class PdoLinkRepository implements LinkRepositoryInterface
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function add(Link $link)
    {
        $query = 'INSERT INTO links VALUES (?, ?, ?, ?)';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(1, $link->uid());
        $stmt->bindValue(2, $link->url());
        $stmt->bindValue(3, $link->code());
        $stmt->bindValue(4, $link->createdAt());
        $stmt->execute();
    }

    public function findByUrl($url)
    {
        $query = 'SELECT * FROM links WHERE url = :url';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':url', $url, PDO::PARAM_STR);
        $stmt->execute();

        $found = $stmt->fetchObject(Link::class);
        if (!$found) {
            throw LinkRepositoryException::notFound();
        }

        return $found;
    }

    public function findByCode($code)
    {
        $query = 'SELECT * FROM links WHERE code = :code';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':code', $code, PDO::PARAM_STR);
        $stmt->execute();

        $found = $stmt->fetchObject(Link::class);
        if (!$found) {
            throw LinkRepositoryException::notFound();
        }

        return $found;
    }
}
