<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $github_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bookmarks_count;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $comments_count;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $likes_count;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $contributions_count;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contribution", mappedBy="user")
     */
    private $contributions;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $github_handle;

    public function __construct()
    {
        $this->contributions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGithubId(): ?string
    {
        return $this->github_id;
    }

    public function setGithubId(string $github_id): self
    {
        $this->github_id = $github_id;

        return $this;
    }

    public function getBookmarksCount(): ?int
    {
        return $this->bookmarks_count;
    }

    public function setBookmarksCount(?int $bookmarks_count): self
    {
        $this->bookmarks_count = $bookmarks_count;

        return $this;
    }

    public function getCommentsCount(): ?int
    {
        return $this->comments_count;
    }

    public function setCommentsCount(?int $comments_count): self
    {
        $this->comments_count = $comments_count;

        return $this;
    }

    public function getLikesCount(): ?int
    {
        return $this->likes_count;
    }

    public function setLikesCount(?int $likes_count): self
    {
        $this->likes_count = $likes_count;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getContributionsCount(): ?int
    {
        return $this->contributions_count;
    }

    public function setContributionsCount(?int $contributions_count): self
    {
        $this->contributions_count = $contributions_count;

        return $this;
    }

    /**
     * @return Collection|Contribution[]
     */
    public function getContributions(): Collection
    {
        return $this->contributions;
    }

    public function addContribution(Contribution $contribution): self
    {
        if (!$this->contributions->contains($contribution)) {
            $this->contributions[] = $contribution;
            $contribution->setUser($this);
        }

        return $this;
    }

    public function removeContribution(Contribution $contribution): self
    {
        if ($this->contributions->contains($contribution)) {
            $this->contributions->removeElement($contribution);
            // set the owning side to null (unless already changed)
            if ($contribution->getUser() === $this) {
                $contribution->setUser(null);
            }
        }

        return $this;
    }

    public function getGithubHandle(): ?string
    {
        return $this->github_handle;
    }

    public function setGithubHandle(string $github_handle): self
    {
        $this->github_handle = $github_handle;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
}
