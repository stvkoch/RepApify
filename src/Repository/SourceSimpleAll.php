<?php
namespace ApiLayer\Repository;

use Psr\Http\Message\ServerRequestInterface as ReqInterface;
use Psr\Http\Message\ResponseInterface as ResInterface;

class SourceSimpleAll{

    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function call($query)
    {
        //$con = $this->container->get('connection_read');
        return ''.$query;
    }
}

