<?php
namespace ApiLayer\Middleware;

use Psr\Http\Message\ServerRequestInterface as ReqInterface;
use Psr\Http\Message\ResponseInterface as ResInterface;

class RetrieveData {

    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function __invoke(ReqInterface $req, ResInterface $res)
    {
        $route = $req->getAttribute('route');
        $table = $route->getArgument('table');

        $query = $this->container->get('query');

        $repository = $this->container->get('repository');

        // each table could belogn to different source
        $source = $repository->source($table);

        $data = $source->call($query);
        $res->getBody()->write($data);

        return $res;
    }
}
