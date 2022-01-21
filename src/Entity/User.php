<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * itemOperations= {
 *      "get" = {
 *          "normalization_context" = {"groups" = {"userId"}}
 *      },
 *      "delete", "put"
 * },
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"postTopic"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"userId"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("userId")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("userId")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("userId")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"userId", "topicId", "topics","categorieId","postTopic"})
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity=Topic::class, mappedBy="user", orphanRemoval=true)
     * @Groups({"userId"})
     */
    private $topics;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user", orphanRemoval=true)
     * @Groups("userId")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Subcomment::class, mappedBy="user")
     */
    private $subcomments;

    /**
     * @ORM\OneToMany(targetEntity=Communication::class, mappedBy="sender", orphanRemoval=true)
     */
    private $sender;

    /**
     * @ORM\OneToMany(targetEntity=Communication::class, mappedBy="recipient", orphanRemoval=true)
     */
    private $recipient;

    /**
     * @ORM\OneToOne(targetEntity=Rib::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $rib;

    public function __construct()
    {
        $this->topics = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->subcomments = new ArrayCollection();
        $this->sender = new ArrayCollection();
        $this->recipient = new ArrayCollection();
        $this->rib = new Rib($this);
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getRIB(): ?Rib
    {
        return $this->rib;
    }

    public function setRIB(Rib $rib): self
    {
        $this->rib = $rib;

        return $this;
    }

    /**
     * @return Collection|Topic[]
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics[] = $topic;
            $topic->setUser($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topics->removeElement($topic)) {
            // set the owning side to null (unless already changed)
            if ($topic->getUser() === $this) {
                $topic->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Subcomment[]
     */
    public function getSubcomments(): Collection
    {
        return $this->subcomments;
    }

    public function addSubcomment(Subcomment $subcomment): self
    {
        if (!$this->subcomments->contains($subcomment)) {
            $this->subcomments[] = $subcomment;
            $subcomment->setUser($this);
        }

        return $this;
    }

    public function removeSubcomment(Subcomment $subcomment): self
    {
        if ($this->subcomments->removeElement($subcomment)) {
            // set the owning side to null (unless already changed)
            if ($subcomment->getUser() === $this) {
                $subcomment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Communication[]
     */
    public function getSender(): Collection
    {
        return $this->sender;
    }

    public function addSender(Communication $sender): self
    {
        if (!$this->sender->contains($sender)) {
            $this->sender[] = $sender;
            $sender->setSender($this);
        }

        return $this;
    }

    public function removeSender(Communication $sender): self
    {
        if ($this->sender->removeElement($sender)) {
            // set the owning side to null (unless already changed)
            if ($sender->getSender() === $this) {
                $sender->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Communication[]
     */
    public function getRecipient(): Collection
    {
        return $this->recipient;
    }

    public function addRecipient(Communication $recipient): self
    {
        if (!$this->recipient->contains($recipient)) {
            $this->recipient[] = $recipient;
            $recipient->setRecipient($this);
        }

        return $this;
    }

    public function removeRecipient(Communication $recipient): self
    {
        if ($this->recipient->removeElement($recipient)) {
            // set the owning side to null (unless already changed)
            if ($recipient->getRecipient() === $this) {
                $recipient->setRecipient(null);
            }
        }

        return $this;
    }
}
