<?php
namespace ApiLayer\Middleware;

use Psr\Http\Message\ServerRequestInterface as ReqInterface;
use Psr\Http\Message\ResponseInterface as ResInterface;

class ParseQuery {

    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function __invoke(ReqInterface $req, ResInterface $res, $next)
    {
        $route = $req->getAttribute('route');
        $table = strtolower($route->getArgument('table'));

        if ($this->container->has('interpreter'.$table)) {
            $interpreter = $this->container->get('interpreter'.$table);
        }

        if (!isset($interpreter)) {
            $interpreter = $this->container->get('interpreter');
        }

        $query = $interpreter->interpret($req);
        $this->container['query'] = $query;
        $res = $next($req, $res);
        return $res;
    }
}
