<?

namespace App;

use Middlewares\Utils\CallableHandler;
use Middlewares\Utils\Dispatcher;
use Zend\Diactoros\ServerRequestFactory;

class Kernel
{
    protected $dispatcher;

    public function __construct()
    {
        $dispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
            $routes = include('../config/routes.php');
            foreach ($routes as $route) {
                $r->addRoute($route[0], $route[1], $route[2]);
            }
        });

        $this->dispatcher = new Dispatcher([
            new \Middlewares\FastRoute($dispatcher),
            new CallableHandler(function ($request) {
                list($controllerName, $controllerMethod, $middlewares, $idNeed) = $request->getAttribute('request-handler');

                //init middlewares for current uri
                if ($middlewares) {
                    foreach ($middlewares as $middleware) {
                        $middleware = '\\Middleware\\' . ucfirst($middleware);
                        $request = $middleware::handle($request);
                    }
                }

                //call needed Controller action
                $controllerName = '\\Controller\\' . ucfirst($controllerName).'Controller';
                $controller = new $controllerName();
                $params = [$request];
                if($idNeed) {
                    $path = explode('/', $request->getUri()->getPath());
                    array_push($params, end($path));
                }

//                $response = $controller->{$controllerMethod}($request);
                $response = call_user_func_array(array($controller, $controllerMethod), $params);
                return $response;
            })
        ]);
    }

    public function initialize() {
        $request = ServerRequestFactory::fromGlobals();
        //check user authorization
        if(!\Middleware\UserAuthorization::handle() && $request ->getUri()->getPath() !== '/users/login') {
            $request = ServerRequestFactory::createServerRequest('GET', '/');
        }
        $response = $this->dispatcher->dispatch($request);
        echo $response->getBody();
    }
}