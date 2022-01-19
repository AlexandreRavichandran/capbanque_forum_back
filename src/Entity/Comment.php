<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\HasLifecycleCallbacks
 * @ApiResource(
 *     itemOperations={"get","delete","put"},
 *  collectionOperations= {
 *      "get",
 *      "post" : {
 *          "denormalization_context" : {"groups" : {"postComment"}}     
 *          }
 * }      
 * )
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"categorieId","topics"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"userId","topicId", "postComment"})
     */
    private $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"userId","topicId"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Topic::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"postComment"})
     */
    private $topic;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"postComment","topicId"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Subcomment::class, mappedBy="comment", orphanRemoval=true)
     * @Groups({"topicId"})
     */
    private $subcomments;


    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->updated_at = new \DateTimeImmutable();
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated_at = new \DateTimeImmutable();
    }

    public function __construct()
    {
        $this->subcomments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getTopic(): ?Topic
    {
        return $this->topic;
    }

    public function setTopic(?Topic $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $subcomment->setComment($this);
        }

        return $this;
    }

    public function removeSubcomment(Subcomment $subcomment): self
    {
        if ($this->subcomments->removeElement($subcomment)) {
            // set the owning side to null (unless already changed)
            if ($subcomment->getComment() === $this) {
                $subcomment->setComment(null);
            }
        }

        return $this;
    }
}
