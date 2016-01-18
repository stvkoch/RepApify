<?php
namespace ApiLayer\Interpreter;

use Psr\Http\Message\ServerRequestInterface as ReqInterface;

interface SimpleInterpreterInterface
{

    public function interpret(ReqInterface $req);

}
