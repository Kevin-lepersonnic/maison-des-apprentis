<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le nom est trop court ! Minimum {{ limit }} charactères requis',
        maxMessage: 'Le nom est trop long ! Maximum  {{ limit }} charactères',
    )]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le nom est trop court ! Minimum {{ limit }} charactères requis',
        maxMessage: 'Le nom est trop long ! Maximum  {{ limit }} charactères',
    )]
    private $lastname;


    private $fullname;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le mot de passe est trop court ! Minimum {{ limit }} charactères requis',
        maxMessage: 'Le mot de passe est trop long ! Maximum  {{ limit }} charactères',
    )]
    private $hash;

    #[Assert\EqualTo(propertyPath: 'hash',
                    message: 'votre mot de passe doit être identique'
    )]
    private $passwordConfirm;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Url(
        message: "l'url n'est pas valide"
    )] 
    private $avatar;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->lastname ." " .$this->firstname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

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

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getPasswordConfirm(): ?string
    {
        return $this->passwordConfirm;
    }

    public function setPasswordConfirm(string $passwordConfirm): self
    {
        $this->passwordConfirm = $passwordConfirm;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    #[ORM\PrePersist]
    public function initSlug(){

        if (empty($this->slug)) {
            $slug = new Slugify();
            $this->slug = $slug->slugify($this->getFullname() . time() . hash('sha256', $this->getFirstname()));
        }

    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }
    public function getPassword()
    {
        return $this->hash;
    }
    public function getSalt()
    {
        return null;
    }
    public function getUsername()
    {
        return $this->email;
    }
    public function eraseCredentials()
    {
        
    }

    // possible bug intervertir avec getUsername
    public function getUserIdentifier(){
        return $this->email;
    }
}
