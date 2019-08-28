<?
require 'Exception/RouteException.php';

class Kernel{
    /**
     * Kernel constructor
     * 
     * @param Request $request
     */
    public function __construct(Request $request) {
        if(isset($_SESSION['user'])) {
            list($controllerName, $controllerMethod, $params) = $request->getRoute();
        } else { //redirect to user login if current user not authorized
            list($controllerName, $controllerMethod, $params) = ['user', 'login', []];
        }
        $this->handle($controllerName, $controllerMethod, $params);
    }

    /**
     * Detects what Controller/action should be run
     * 
     * @param string $controllerName
     * @param string $controllerMethod
     * @param array $params
     */
	public function handle($controllerName='', $controllerMethod='', $params=[]) {
		$controllerName = ($controllerName === '' || $controllerName === null) ? 'user' : ucfirst($controllerName);
		//if no such Controller
        try {
            if(!file_exists(ROOTPATH.DIRECTORY_SEPARATOR.'src/Controller'.DIRECTORY_SEPARATOR.$controllerName.'Controller.php')) {
                throw new RouteException();
            }
            require_once ROOTPATH.DIRECTORY_SEPARATOR.'src/Controller'.DIRECTORY_SEPARATOR.$controllerName.'Controller.php';
            $controllerName = $controllerName.'Controller';

            try {
                //if no Class in Controller
                if(!class_exists($controllerName)) {
                    throw new RouteException();
                }
                $controller = new $controllerName;
                $controllerMethod = ($controllerMethod === '' || $controllerMethod === null) ? 'login' : $controllerMethod;
                try {
                    //if no method in mentionated controller
                    if(!method_exists($controller,$controllerMethod)) {
                        throw new RouteException();
                    }
                    return call_user_func_array(array($controller, $controllerMethod), $params); //can be different count of params, that's why we use call_user_func_array()
                } catch(RouteException $exception) {
                    $exception->getErrorMessage();
                }
                
            } catch (RouteException $exception) {
                $exception->getErrorMessage();
            }
        } catch (RouteException $exception) {
            $exception->getErrorMessage();
        }
	}
}