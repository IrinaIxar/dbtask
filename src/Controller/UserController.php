<?php
require '../src/Repository/UserRepository.php';

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
            echo json_encode(['result' => 'No such login']);
        } else {
            if (md5($params['password']) !== $user->getPassword()) {
                echo json_encode(['result' => 'Incorrect password']);
            } else {
                $_SESSION['user'] = $params['login'];
                echo json_encode(['result' => 'true']);
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
            echo json_encode(['result' => 'Please choose another login, it is already exist']);
        } else {
            if ($params['addPassword'] !== $params['passwordRepeat']) {
                echo json_encode(['result' => 'Please repeat password, because they are not the same']);
            } else {
                $result = $userRepository->add($request);
                $_SESSION['user'] = $params['addLogin'];
                echo json_encode(['result' => 'true']);
            }
        }
    }
}