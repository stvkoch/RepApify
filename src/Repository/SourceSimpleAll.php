<?php
namespace ApiLayer\Repository;

use Psr\Http\Message\ServerRequestInterface as ReqInterface;
use Psr\Http\Message\ResponseInterface as ResInterface;

class SourceSimpleAll implements SourceInterface
{

    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function call($query)
    {
        $con = $this->container->get('connectionRead');
        $stmt = $con->prepare($query->sql());
        $query->bind($stmt);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

