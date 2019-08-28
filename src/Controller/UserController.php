<?php
require '../src/Repository/UserRepository.php';

class UserController extends BaseController {
	/**
     * Login action
     *
     * @return mixed string|view 
     */ 
	public function login() {
		if(isset($_POST['login'])) {
			$userRepository = new UserRepository();
			$user = $userRepository->findByLogin($_POST['login']);
			if(empty($user) || $user === null) {
				echo json_encode(['result' => 'No such login']);
			} else if (md5($_POST['password']) !== $user->getPassword()) {
				echo json_encode(['result' => 'Incorrect password']);
			} else {
				$_SESSION['user'] = $_POST['login'];
				echo json_encode(['result' => 'true']);
			}
		} else {
			echo $this->render('User/login.html', []);
		}	
	}

	/**
     * Create user
     *
     * @return mixed string|view 
     */ 
	public function add() {
		if(isset($_POST['addLogin'])) {
			$userRepository = new UserRepository();
			$user = $userRepository->findByLogin($_POST['addLogin']);

			if(!empty($user)) {
				echo json_encode(['result' => 'Please choose another login, it is already exist']);
			} else if ($_POST['addPassword'] !== $_POST['passwordRepeat']) {
				echo json_encode(['result' => 'Please repeat password, because they are not the same']);
			} else {
				$user = new User();
				$user->setLogin($_POST['addLogin']);
				$user->setPassword(md5($_POST['addPassword']));
				$user->setDeleted(0);

				$result = $userRepository->add($user);
				$_SESSION['user'] = $_POST['addLogin'];
				header('Location: /product/list');
			}
		}		
	}
}