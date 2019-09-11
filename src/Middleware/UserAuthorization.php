<?
require_once '../src/Controller/UserController.php';

class UserAuthorization
{
    public function handle()
    {
        return $_SESSION['user'] ?: false;
    }
}