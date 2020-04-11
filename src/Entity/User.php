<?php

namespace Places\Entity;

use Places\Utility\GeneralUtility;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="Places\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User extends AbstractEntity implements UserInterface
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected string $email = '';

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected string $name = '';

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected string $location = '';

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20)
     */
    protected string $phoneNumber = '';

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected string $role = '';

    /**
     * @var string The hashed password
     *
     * @ORM\Column(type="string")
     */
    protected string $password;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected bool $confirmed = false;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected string $emailConfirmationToken = '';

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected string $passwordResetToken = '';

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Places\Entity\Place", mappedBy="user", orphanRemoval=true)
     */
    private Collection $places;

    public function __construct()
    {
        $this->places = new ArrayCollection();
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
     * @return self
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name = ''): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return self
     */
    public function setLocation(string $location = ''): User
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     * @return self
     */
    public function setPhoneNumber(string $phoneNumber = ''): User
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return [$this->getRole()];
    }

    /**
     * @param string $role
     * @return self
     */
    public function setRole(string $role): User
    {
        $this->role = $role;
        return $this;
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
     * @return self
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return bool
     */
    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    /**
     * @param bool $confirmed
     * @return self
     */
    public function setConfirmed(bool $confirmed): User
    {
        $this->confirmed = $confirmed;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailConfirmationToken(): string
    {
        return $this->emailConfirmationToken;
    }

    /**
     * @param string $emailConfirmationToken
     * @return self
     */
    public function setEmailConfirmationToken(string $emailConfirmationToken = ''): User
    {
        $this->emailConfirmationToken = $emailConfirmationToken;
        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function updatEmailConfirmationToken()
    {
        $this->emailConfirmationToken = GeneralUtility::generateRandomToken();
    }

    /**
     * @return string
     */
    public function getPasswordResetToken(): string
    {
        return $this->passwordResetToken;
    }

    /**
     * @param string $passwordResetToken
     * @return self
     */
    public function setPasswordResetToken(string $passwordResetToken = ''): User
    {
        $this->passwordResetToken = $passwordResetToken;
        return $this;
    }

    /**
     * @return void
     */
    public function updatePasswordResetToken()
    {
        $this->passwordResetToken = GeneralUtility::generateRandomToken();
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @return Collection|Place[]
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    /**
     * @param Place $post
     * @return self
     */
    public function addPost(Place $post): self
    {
        if (!$this->places->contains($post)) {
            $this->places[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    /**
     * @param Place $post
     * @return self
     */
    public function removePost(Place $post): self
    {
        if ($this->places->contains($post)) {
            $this->places->removeElement($post);
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }
}
