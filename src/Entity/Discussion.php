<?php

namespace App\Entity;

use App\Repository\DiscussionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiscussionRepository::class)
 */
class Discussion
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
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $nmb_post;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="discussions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="discussions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="text", length=500, nullable=true)
     */
    private $first_post;

    /**
     * @ORM\ManyToOne(targetEntity=Places::class, inversedBy="discussions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $place;

    // l’attribut cascade = all  permet qu’un évènement doctrine sur l’entité Galerie
    // déclanche en cascade le même évènement sur l’entité Image :
    // on persite une galerie donc on persiste ses images,
    // on supprime une galerie donc on supprime ses images.
    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="discussion", cascade="all")
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNmbPos(): ?int
    {
        return $this->nmb_post;
    }

    public function setNmbPost(int $nmb_post): self
    {
        $this->nmb_post = $nmb_post;

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


    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFirstPost(): ?string
    {
        return $this->first_post;
    }

    public function setFirstPost(?string $first_post): self
    {
        $this->first_post = $first_post;

        return $this;
    }

    public function getPlace(): ?places
    {
        return $this->place;
    }

    public function setPlace(?places $place): self
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setDiscussion($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getDiscussion() === $this) {
                $post->setDiscussion(null);
            }
        }

        return $this;
    }
}
