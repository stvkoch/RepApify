<?php
namespace ApiLayer\Repository;

use Psr\Http\Message\ServerRequestInterface as ReqInterface;
use Psr\Http\Message\ResponseInterface as ResInterface;

interface SourceInterface
{

    public function call($query);

}

