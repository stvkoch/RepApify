<?php
namespace ApiLayer\Interpreter;

use Psr\Http\Message\ServerRequestInterface as ReqInterface;

class SimpleQuery {

    protected $mapHttpMethodsToSQLOper = [
        'GET' => 'Select',
        'POST' => 'Insert',
        'PUT' => 'Update',
        'DELETE' => 'Delete',
        'OPTIONAL' => 'hashCode'
    ];

    const DEFAULT_PER_PAGE = 20;



    public function bornToBe(ReqInterface $req)
    {
        $method = $req->getMethod();
        if (isset($this->mapHttpMethodsToSQLOper[$method])) {
            return $this->mapHttpMethodsToSQLOper[$method];
        }
        return $this->mapHttpMethodsToSQLOper['GET'];
    }

    public function interpret(ReqInterface $req)
    {
        $route = $req->getAttribute('route');
        $table = $route->getArgument('table');
        $id = $route->getArgument('id');

        $model = new \Simple\Model([
            'table' => $table
        ]);

        $query = new \Simple\Query($model, $this->bornTobe($req));

        $this->parseId($id, $query);
        $this->parseMatch($req, $query, $req->getParam('match'), 'AND');
        $this->parseMatch($req, $query, $req->getParam('or_match'), 'OR');
        $this->parseLike($req, $query, $req->getParam('like'), 'AND');
        $this->parseLike($req, $query, $req->getParam('or_like'), 'OR');
        $this->parseOrder($req, $query);
        $this->parsePage($req, $query);

        return $query;
    }


    protected function parseId($id, $query)
    {
        if (!is_null($id)) {
            $query->where(
                $query->from->field($query->from->pk()),
                $id
            );
        }
    }

    protected function parseMatch($req, $query, $matchs = [], $oper = 'AND')
    {
        if (is_array($matchs)) {
            foreach ($matchs as $field => $value) {
                $query->where(
                    $query->from->field($field),
                    $value,
                    is_array($value)?'IN':'=',
                    $oper
                );
            }
        }
    }

    protected function parseLike($req, $query, $likes = [], $oper = 'AND')
    {
        if (is_array($likes)) {
            foreach ($likes as $field => $value) {
                $query->where(
                    $query->from->field($field),
                    sprintf('\%%s\%', $value),
                    'LIKE',
                    $oper
                );
            }
        }
    }


    protected function parseOrder($req, $query) {
        $orders = $req->getParam('order');
        if (is_array($orders)) {
            foreach ($orders as $field => $direction) {
                $query->order($query->from->field($field), $direction);
            }
        }
    }

    protected function parsePage($req, $query) {
        $page = (int)$req->getParam('page') ?: 1;
        $query->page($page, self::DEFAULT_PER_PAGE);
    }

    protected function parseInclude($req, $query) {
    }


}
