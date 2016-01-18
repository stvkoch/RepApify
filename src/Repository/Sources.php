<?php
namespace ApiLayer\Repository;

use Psr\Http\Message\ServerRequestInterface as ReqInterface;
use Psr\Http\Message\ResponseInterface as ResInterface;

class Sources {

    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    /**
    * choose what source whe can call
    */
    public function source(ReqInterface $req)
    {
        $route = $req->getAttribute('route');
        $table = strtolower($route->getArgument('table'));
        // you can create a item container that can fetch from
        // expecific source data
        if ($this->container->has('source'.$table)) {
            return $this->container->get('source'.$table);
        }

        $source = $this->container->get('sourceToAll');

        return $source;
    }
}

