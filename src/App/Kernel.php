<?
require_once '../vendor/autoload.php';
require_once '../src/Controller/BaseController.php';

use Middlewares\Utils\CallableHandler;
use Middlewares\Utils\Dispatcher;
use Zend\Diactoros\ServerRequestFactory;

class Kernel
{
    protected $dispatcher;

    public function __construct()
    {
        $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
            $routes = include('../config/routes.php');
            foreach ($routes as $route) {
                $r->addRoute($route[0], $route[1], $route[2]);
            }
        });

        $this->dispatcher = new Dispatcher([
            new Middlewares\FastRoute($dispatcher),
            new CallableHandler(function ($request) {
                list($controllerName, $controllerMethod, $middlewares) = $request->getAttribute('request-handler');

                //init middlewares for current uri
                if ($middlewares) {
                    foreach ($middlewares as $middleware) {
                        $middleware = ucfirst($middleware);
                        $path = implode(DIRECTORY_SEPARATOR, [ROOTPATH, 'src', 'Middleware', $middleware.'.php']);
                        require $path;
                        $request = $middleware::handle($request);
                    }
                }

                //call needed Controller action
                $controllerName = ucfirst($controllerName).'Controller';
                $path = implode(DIRECTORY_SEPARATOR, [ROOTPATH, 'src', 'Controller', $controllerName.'.php']);
                require_once $path;
                $controller = new $controllerName();
                $response = $controller->{$controllerMethod}($request);
                return $response;
            })
        ]);
    }

    public function initialize() {
        $response = $this->dispatcher->dispatch(ServerRequestFactory::fromGlobals());
        echo $response->getBody();
    }
}