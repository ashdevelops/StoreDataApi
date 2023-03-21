<?php declare(strict_types = 1);

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/store/is-open', ['App\Controllers\StoreController', 'isOpenAt']);
    $r->addRoute('GET', '/store/next-open', ['App\Controllers\StoreController', 'nextOpenFrom']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404';
        break;
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = $routeInfo[1];
            echo 'Allowed methods: ' . implode(', ', $allowedMethods);
            break;
        break;
        case FastRoute\Dispatcher::FOUND:
            $location = $routeInfo[1];
            $controller = $routeInfo[1][0];
            $method = $routeInfo[1][1];
            $class = new $controller();
            $response = call_user_func_array(array($class, $method), [ getTimestamp() ]);

            header('Content-type: application/json');
            echo json_encode(['response' => $response]);
            break;
}