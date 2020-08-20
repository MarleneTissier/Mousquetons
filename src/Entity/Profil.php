<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 */
class Profil
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Avatar;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="profil", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAvatar(): ?string
    {
        return $this->Avatar;
    }

    /**
     * @param string $Avatar
     * @return Profil
     */
    public function setAvatar(string $Avatar): self
    {
        $this->Avatar = $Avatar;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->Description;
    }

    /**
     * @param string $Description
     * @return Profil
     */
    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(user $user): self
    {
        $this->user = $user;

        return $this;
    }


}
