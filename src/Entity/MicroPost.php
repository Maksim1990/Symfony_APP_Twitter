<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\MicroPostRepository")
 * @ORM\Table(name="micro_post")
 */
class MicroPost
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @ORM\Column(type="string", length=280)
     * @Assert\NotBlank()
     * @\Symfony\Component\Validator\Constraints\Length(min="10",minMessage="Not enough characters for this field. Min 10 characters")
     */
    private $text;
    /**
     * @ORM\Column(type="datetime")
     */
    private $time;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="postsLiked")
     * @ORM\JoinTable(name="post_likes",
     *     joinColumns={
     *     @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * },
     *     inverseJoinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")})
     */
    private $likedBy;

    /**
     * @return mixed
     */
    public function getLikedBy()
    {
        return $this->likedBy;
    }


    public function __construct()
    {
        $this->likedBy=new ArrayCollection();
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @param mixed User
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }
    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }
    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
    }
    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }
    /**
     * @param mixed $time
     */
    public function setTime($time): void
    {
        $this->time = $time;
    }

    /**
     * @param \App\Entity\User $user
     */
    public function like(User $user): void
    {
       if( !$this->likedBy->contains($user)){
           $this->likedBy->add($user);
       }
    }
}