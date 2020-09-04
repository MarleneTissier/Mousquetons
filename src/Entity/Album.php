<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlbumRepository::class)
 */
class Album
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
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="albums")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=categorie::class, inversedBy="albums")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=post::class, inversedBy="albums")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    // l’attribut cascade = all  permet qu’un évènement doctrine sur l’entité Galerie
    // déclanche en cascade le même évènement sur l’entité Image :
    // on persite une galerie donc on persiste ses images,
    // on supprime une galerie donc on supprime ses images.
    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="galerie", cascade="all")
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCategorie(): ?categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getPost(): ?post
    {
        return $this->post;
    }

    public function setPost(?post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function setImages(string $images)
    {
        $this->images = $images;

        return $this;
    }

    public function addImages(Image $images): self
    {
        if (!$this->images->contains($images)) {
            $this->images[] = $images;
            $images->setAlbum($this);
        }

        return $this;
    }

    public function removeImages(Image $images): self
    {
        if ($this->images->contains($images)) {
            $this->images->removeElement($images);
            // set the owning side to null (unless already changed)
            if ($images->getAlbum() === $this) {
                $images->setAlbum()(null);
            }
        }

        return $this;
    }
}
