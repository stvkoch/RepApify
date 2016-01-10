<?php
namespace ApiLayer\Repository;

use Psr\Http\Message\ServerRequestInterface as ReqInterface;
use Psr\Http\Message\ResponseInterface as ResInterface;

class Sources {

    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function source($table)
    {
        if ($this->container->has('source_'.$table)) {
            return $this->container->get('source_'.$table);
        }

        $source = $this->container->get('source_to_all');
        return $source;
    }
}

