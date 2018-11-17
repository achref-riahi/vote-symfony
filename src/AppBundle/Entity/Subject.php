<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Exclude;

/**
 * Subject
 *
 * @ORM\Table(name="subject")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubjectRepository")
 */
class Subject
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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="SubjectOption", mappedBy="subject")
     * @Exclude
     */
    private $subjectoptions;


    /**
     * @ORM\OneToMany(targetEntity="Vote", mappedBy="subject")
     * @Exclude
     */
    private $votes;

    public function __construct()
    {
        $this->subjectoptions = new ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     *
     * @return Subject
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Subject
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
     * Add subjectoption
     *
     * @param \AppBundle\Entity\SubjectOption $subjectoption
     *
     * @return Subject
     */
    public function addSubjectoption(\AppBundle\Entity\SubjectOption $subjectoption)
    {
        $this->subjectoptions[] = $subjectoption;

        return $this;
    }

    /**
     * Remove subjectoption
     *
     * @param \AppBundle\Entity\SubjectOption $subjectoption
     */
    public function removeSubjectoption(\AppBundle\Entity\SubjectOption $subjectoption)
    {
        $this->subjectoptions->removeElement($subjectoption);
    }

    /**
     * Get subjectoptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubjectoptions()
    {
        return $this->subjectoptions;
    }

    /**
     * @VirtualProperty
     * @SerializedName("options")
     */
    public function options()
    {
      $options = array();
      foreach ($this->getSubjectoptions() as $option) {
          array_push($options, array("id"=>$option->getId(), "name"=>$option->getName()));
      }
      return $options;
    }

    /**
     * Add vote
     *
     * @param \AppBundle\Entity\Vote $vote
     *
     * @return Subject
     */
    public function addVote(\AppBundle\Entity\Vote $vote)
    {
        $this->votes[] = $vote;

        return $this;
    }

    /**
     * Remove vote
     *
     * @param \AppBundle\Entity\Vote $vote
     */
    public function removeVote(\AppBundle\Entity\Vote $vote)
    {
        $this->votes->removeElement($vote);
    }

    /**
     * Get votes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVotes()
    {
        return $this->votes;
    }
}
