<?php



namespace App\Service;


use App\Interfaces\Auth\IAuthenticatedUser;
use Symfony\Component\Security\Core\Security;

class AuthService implements IAuthenticatedUser
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getAuthenticatedUser()
    {
        return $this->security->getUser();
    }
}