<?php
$container = new \Slim\Container([
    'query' => null,
    'settings' => [
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true
    ]
]);

/*
@var MiddlewareInterface
middleware parse and create a query
*/
$container['parser'] = function ($container) {
    return new \ApiLayer\Middleware\ParseQuery($container);
};

/*
@var InterpreterInterface
used by parser to interpret request and return a query
*/
$container['interpreter'] = function ($container) {
    return new \ApiLayer\Interpreter\SimpleQuery();
};

/*
@var MiddlewareInterface
middleware that handle repository to retrieve DB data
*/
$container['retrieveData'] = function ($container) {
    return new \ApiLayer\Middleware\RetrieveData($container);
};

/*
@var RepositoryInterface
repository that fetch data by query
*/
$container['repository'] = function ($container) {
    return new \ApiLayer\Repository\Sources($container);
};

/*
@var Respository Source SimpleAll
handler all connections
*/
$container['sourceToAll'] = function ($container) {
    return new \ApiLayer\Repository\SourceSimpleAll($container);
};

$container['connectionRead'] = function ($container) {
    $pdo = new PDO('sqlite:'.__DIR__.'/../../data/development.sqlite3');
    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );
    return $pdo;
};

return $container;
