<?

namespace Middleware;

class UserAuthorization
{
    public function handle()
    {
        return $_SESSION['user'] ?: false;
    }
}