<?php

namespace ST\TricksBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ST\TricksBundle\Entity\Image;
use ST\TricksBundle\Entity\Video;
use ST\TricksBundle\Entity\Category;
use ST\UserBundle\Entity\Comment;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Trick
 *
 * @ORM\Table(name="trick")
 * @ORM\Entity(repositoryClass="ST\TricksBundle\Repository\TrickRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @UniqueEntity(fields="name", message="Un trick existe déjà avec ce titre.")
 */
class Trick
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Le trick doit comporter obligatoirement un nom.")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank(message="Le trick doit comporter obligatoirement une description même succinte.")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="ST\TricksBundle\Entity\Category", cascade={"persist"}, inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="ST\TricksBundle\Entity\Image", mappedBy="trick", cascade={"persist","remove"})
     * @Assert\Valid()
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="ST\TricksBundle\Entity\Video", mappedBy="trick", cascade={"persist","remove"})
     * @Assert\Valid()
     */
    private $videos;

    /**
     * @ORM\OneToMany(targetEntity="ST\UserBundle\Entity\Comment", mappedBy="trick", cascade={"persist","remove"})
     */
    private $comments;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetimetz")
     * @Assert\DateTime()
     */
    private $dateCreation;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;
        
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Trick
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Trick
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set category
     *
     * @param Category $category
     *
     * @return Trick
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCreation = new \Datetime();
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * Add image
     *
     * @param Image $image
     *
     * @return Trick
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;
        $image->setTrick($this);

        return $this;
    }

    /**
     * Remove image
     *
     * @param Image $image
     */
    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add video
     *
     * @param Video $video
     *
     * @return Trick
     */
    public function addVideo(Video $video)
    {
        $this->videos[] = $video;
        $video->setTrick($this);

        return $this;
    }

    /**
     * Remove video
     *
     * @param Video $video
     */
    public function removeVideo(Video $video)
    {
        $this->videos->removeElement($video);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Add comment
     *
     * @param Comment $comment
     *
     * @return Trick
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
        $comment->setTrick($this);

        return $this;
    }

    /**
     * Remove comment
     *
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Trick
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setUpdatedAt(new \Datetime());
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Trick
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}