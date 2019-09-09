<?
require_once '../vendor/autoload.php';
require_once '../src/Controller/BaseController.php';

class Kernel{
    protected $dispatcher;

    public function __construct() {
        $this->dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r){
            $routes = include('../config/routes.php');
            foreach ($routes as $route) {
                $r->addRoute($route[0], $route[1], $route[2]);
            }
        });
    }

    public function initialize($request) {
        $uri = $request->getUri()->getPath();
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $routeInfo = $this->dispatcher->dispatch($_SERVER['REQUEST_METHOD'], rawurldecode($uri));
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                echo 'Not found such route';
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                $allowed = '';
                foreach ($allowedMethods as $index => $method) {
                    $allowed .= $method . ($allowedMethods[($index + 1)] ? ',' : '');
                }
                echo 'Not allowed method. Please try ' . $allowed;
                break;
            case FastRoute\Dispatcher::FOUND:
                list($controllerName, $controllerMethod, $middlewares) = $routeInfo[1];

                //init middlewares for current uri
                if($middlewares) {
                    foreach ($middlewares as $middleware) {
                        $middleware = ucfirst($middleware);
                        $path = implode(DIRECTORY_SEPARATOR, [ROOTPATH, 'src', 'Middleware', $middleware . '.php']);
                        require $path;
                        $request = $middleware::handle($request);
                    }
                }

                //call needed Controller action
                $controllerName = ucfirst($controllerName).'Controller';
                $path = implode(DIRECTORY_SEPARATOR, [ROOTPATH, 'src', 'Controller', $controllerName . '.php']);
                require_once $path;
                $controller = new $controllerName();
                $controller->{$controllerMethod}($request);
                break;
        }
    }
}