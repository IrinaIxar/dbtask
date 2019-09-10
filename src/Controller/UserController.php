<?php
require '../src/Repository/UserRepository.php';
use Zend\Diactoros\Response;

class UserController extends BaseController
{

    /**
     * Authorization page action
     *
     * @return view
     */
    public function authorization($request)
    {
        return $this->render('User/authorization.html', []);
    }

    /**
     * Login action
     *
     * @param $request
     * @return string
     */
    public function login($request)
    {
        $params = $request->getParsedBody();
        $userRepository = new UserRepository();
        $user = $userRepository->findByLogin($params['login']);
        if (!$user) {
            return new Response\JsonResponse('No such login');
        } else {
            if (md5($params['password']) !== $user->getPassword()) {
                return new Response\JsonResponse('Incorrect password');
            } else {
                $_SESSION['user'] = $params['login'];
                return new Response\JsonResponse('true');
            }
        }
    }

    /**
     * Add user
     *
     * @param $request
     * @return string
     */
    public function add($request)
    {
        $params = $request->getParsedBody();
        $userRepository = new UserRepository();
        $user = $userRepository->findByLogin($params['addLogin']);

        if ($user) {
            return new Response\JsonResponse('Please choose another login, it is already exist');
        } else {
            if ($params['addPassword'] !== $params['passwordRepeat']) {
                return new Response\JsonResponse('Please repeat password, because they are not the same');
            } else {
                $userRepository->add($request);
                $_SESSION['user'] = $params['addLogin'];
                return new Response\JsonResponse('true');
            }
        }
    }
}