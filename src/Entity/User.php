<?

namespace Entity;

class User implements \JsonSerializable
{
    protected $id;
    protected $login;
    protected $password;
    protected $deleted;

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getDeleted()
    {
        return $this->deleted;
    }

    public function setDeleted($deleted = 0)
    {
        $this->deleted = $deleted;
    }

    /**
     * Method to access private/protected properties of User in json_encode function
     */
    public function jsonSerialize()
    {
        return
            [
                'id' => $this->getId(),
                'login' => $this->getLogin(),
                'password' => $this->getPassword(),
                'deleted' => $this->getDeleted()
            ];
    }
}