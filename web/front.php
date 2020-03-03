<?php
// framework/web/front.php
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$response = new Response;

$map = [
    '/hello' => __DIR__ . '../src/pages/hello.php',
    '/bye' => __DIR__ . '../src/pages/bye.php',
];

$path = $request->getPathInfo();
if(isset($map[$path])){
    ob_start();
    extract($request->query->all(), EXTR_SKIP);
    include sprintf(__DIR__.'/../src/pages/%s.php', $map[$path]);
    $response = new Response(ob_get_clean());
} else {
    $response->setStatusCode(404);
    $response->setContent('Not Found');
}

$response->send();