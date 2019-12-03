<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="players")
 */
class Player implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column
     */
    private $username = '';

    /**
     * @ORM\Column
     */
    private $fullname = '';

    /**
     * @ORM\Column
     */
    private $email = '';

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfBirth;

    /**
     * @ORM\Column
     */
    private $password = '';

    /**
     * @ORM\Column(type="integer", options={"default"="10"})
     */
    private $credits = 10;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLogin;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username) : void
    {
        $this->username = $username;
    }

    public function getFullname(): string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname) : void
    {
        $this->fullname = $fullname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }

    public function getDateOfBirth(): ?\DateTimeImmutable
    {
        if ($this->dateOfBirth instanceof \DateTime) {
            $this->dateOfBirth = \DateTimeImmutable::createFromMutable($this->dateOfBirth);
        }

        return $this->dateOfBirth;
    }

    public function setDateOfBirth(DateTimeInterface $dateOfBirth) : void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }

    public function getRoles(): array
    {
        return ['ROLE_ADMIN'];
    }

    public function getSalt(): void
    {
    }

    public function eraseCredentials(): void
    {
    }

    public function getCredits(): ?int
    {
        return $this->credits;
    }

    public function setCredits(int $credits): self
    {
        $this->credits = $credits;

        return $this;
    }

    public function getLastLogin(): ?DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function recordLastLogin(): void
    {
        $this->lastLogin = new \DateTime('now');
    }

    public function consumeOneCredit() : void
    {
        $this->credits--;
    }
}
