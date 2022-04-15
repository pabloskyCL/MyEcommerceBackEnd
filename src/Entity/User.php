<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=155, nullable=true)
     */
    private $shiping_address;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $postal_code;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getShipingAddress(): ?string
    {
        return $this->shiping_address;
    }

    public function setShipingAddress(?string $shiping_address): self
    {
        $this->shiping_address = $shiping_address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(?string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }
}
