<?php
$container = require('Container.php');

$app = new \Slim\App($container);
$app->group('/api/v1', function () use ($app) {
    $app->any('/data/{table}[/{id}]', function($req, $res, $args) {
        $middleware = $this->get('retrieveData');
        return $middleware($req, $res);
    })
   // ->add('filterSensiveData')
   // ->add('cache')
    ->add('parser')
   // ->add('authorization')
    ;
});

$app->run();


