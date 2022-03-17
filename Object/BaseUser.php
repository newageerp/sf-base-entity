<?php

namespace Newageerp\SfBaseEntity\Object;

use Newageerp\SfBaseEntity\Interface\IUser;
use OpenApi\Annotations as OA;
use Doctrine\ORM\Mapping as ORM;

class BaseUser implements IUser
{
    /**
     * @ORM\Column (type="string")
     */
    protected string $firstName = '';
    /**
     * @ORM\Column (type="string")
     */
    protected string $lastName = '';
    /**
     * @ORM\Column(type="string")
     */
    protected string $email = '';
    /**
     * @ORM\Column(type="string")
     */
    protected string $login = '';
    /**
     * @ORM\Column(type="string")
     */
    protected string $password = '';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function setPlainPassword(string $plainPassword)
    {
        if ($plainPassword) {
            $this->setPassword(password_hash($plainPassword, PASSWORD_BCRYPT));
        }
    }

    /**
     * @OA\Property(ttype="string", format="password")
     * @return string
     */
    public function getPlainPassword(): string
    {
        return '';
    }
}