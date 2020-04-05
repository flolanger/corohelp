<?php

namespace Corohelp\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="Corohelp\Repository\UserRepository")
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
     * @ORM\OneToMany(targetEntity="Corohelp\Entity\Helper", mappedBy="user", orphanRemoval=true)
     */
    private Collection $helpers;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Corohelp\Entity\Seeker", mappedBy="user", orphanRemoval=true)
     */
    private Collection $seekers;

    public function __construct()
    {
        $this->helpers = new ArrayCollection();
        $this->seekers = new ArrayCollection();
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
        try {
            $token = bin2hex(random_bytes(50));
        } catch (Exception $e) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $token = '';
            for ($i = 0; $i < strlen($characters); $i++) {
                $index = rand(0, strlen($characters) - 1);
                $token .= $characters[$index];
            }
        }
        $this->emailConfirmationToken = $token;
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
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @return Collection|Helper[]
     */
    public function getHelpers(): Collection
    {
        return $this->helpers;
    }

    /**
     * @param Helper $post
     * @return self
     */
    public function addPost(Helper $post): self
    {
        if (!$this->helpers->contains($post)) {
            $this->helpers[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    /**
     * @param Helper $post
     * @return self
     */
    public function removePost(Helper $post): self
    {
        if ($this->helpers->contains($post)) {
            $this->helpers->removeElement($post);
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Seeker[]
     */
    public function getSeekers(): Collection
    {
        return $this->seekers;
    }

    /**
     * @param Seeker $seeker
     * @return self
     */
    public function addSeeker(Seeker $seeker): self
    {
        if (!$this->seekers->contains($seeker)) {
            $this->seekers[] = $seeker;
            $seeker->setUser($this);
        }

        return $this;
    }

    /**
     * @param Seeker $seeker
     * @return self
     */
    public function removeSeeker(Seeker $seeker): self
    {
        if ($this->seekers->contains($seeker)) {
            $this->seekers->removeElement($seeker);
            if ($seeker->getUser() === $this) {
                $seeker->setUser(null);
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
