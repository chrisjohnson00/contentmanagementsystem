<?php

namespace cjohnson\ContentManagementSystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Component
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="cjohnson\ContentManagementSystemBundle\Entity\ComponentRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class Component
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text",nullable=true)
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdDate", type="datetime")
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifiedDate", type="datetime")
     */
    private $modifiedDate;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="RowComponent", mappedBy="component")
     * @var $componentRows \cjohnson\ContentManagementSystemBundle\Entity\RowComponent[]
     */
    private $componentRows;

    /**
     * Get id
     *
     * @return integer
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
     * @return Component
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
     * Set content
     *
     * @param string $content
     *
     * @return Component
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Component
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     *
     * @return Component
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param mixed $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedOnValue()
    {
        $this->createdDate  = new \DateTime();
        $this->modifiedDate = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setModifiedOnValue()
    {
        $this->modifiedDate = new \DateTime();
    }

    /**
     * @return \cjohnson\ContentManagementSystemBundle\Entity\RowComponent[]
     */
    public function getComponentRows()
    {
        return $this->componentRows;
    }

    /**
     * @param mixed $componentRows
     */
    public function setComponentRows($componentRows)
    {
        $this->componentRows = $componentRows;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->componentRows = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add componentRow
     *
     * @param \cjohnson\ContentManagementSystemBundle\Entity\RowComponent $componentRow
     *
     * @return Component
     */
    public function addComponentRow(\cjohnson\ContentManagementSystemBundle\Entity\RowComponent $componentRow)
    {
        $this->componentRows[] = $componentRow;

        return $this;
    }

    /**
     * Remove componentRow
     *
     * @param \cjohnson\ContentManagementSystemBundle\Entity\RowComponent $componentRow
     */
    public function removeComponentRow(\cjohnson\ContentManagementSystemBundle\Entity\RowComponent $componentRow)
    {
        $this->componentRows->removeElement($componentRow);
    }
}
