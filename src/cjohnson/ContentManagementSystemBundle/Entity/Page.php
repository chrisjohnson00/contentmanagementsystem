<?php

namespace cjohnson\ContentManagementSystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Page
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="cjohnson\ContentManagementSystemBundle\Entity\PageRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class Page
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
     * @Gedmo\Slug(fields={"name"}, separator="_", updatable=true)
     * @ORM\Column(length=128, unique=true)
     */
    private $uri;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdDate", type="datetime")
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $modifiedDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $cacheTTL;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $isHomePage;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $hideHeader;

    /**
     * @ORM\OneToMany(targetEntity="PageRow", mappedBy="page")
     */
    private $pageRows;

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
     * @return Page
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
     * Set uri
     *
     * @param string $uri
     *
     * @return Page
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Get uri
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Page
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
     * Set published
     *
     * @param boolean $published
     *
     * @return Page
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
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
     * @return \DateTime
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * @param \DateTime $modifiedDate
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;
    }

    /**
     * @return mixed
     */
    public function getPageRows()
    {
        return $this->pageRows;
    }

    /**
     * @param mixed $pageRows
     */
    public function setPageRows($pageRows)
    {
        $this->pageRows = $pageRows;
    }

    /**
     * @return mixed
     */
    public function getCacheTTL()
    {
        return $this->cacheTTL;
    }

    /**
     * @param mixed $cacheTTL
     */
    public function setCacheTTL($cacheTTL)
    {
        $this->cacheTTL = $cacheTTL;
    }

    /**
     * @return mixed
     */
    public function getIsHomePage()
    {
        return $this->isHomePage;
    }

    /**
     * @param mixed $isHomePage
     */
    public function setIsHomePage($isHomePage)
    {
        $this->isHomePage = $isHomePage;
    }

    /**
     * @return mixed
     */
    public function getHideHeader()
    {
        return $this->hideHeader;
    }

    /**
     * @param mixed $hideHeader
     */
    public function setHideHeader($hideHeader)
    {
        $this->hideHeader = $hideHeader;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pageRows = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add pageRow
     *
     * @param \cjohnson\ContentManagementSystemBundle\Entity\PageRow $pageRow
     *
     * @return Page
     */
    public function addPageRow(\cjohnson\ContentManagementSystemBundle\Entity\PageRow $pageRow)
    {
        $this->pageRows[] = $pageRow;

        return $this;
    }

    /**
     * Remove pageRow
     *
     * @param \cjohnson\ContentManagementSystemBundle\Entity\PageRow $pageRow
     */
    public function removePageRow(\cjohnson\ContentManagementSystemBundle\Entity\PageRow $pageRow)
    {
        $this->pageRows->removeElement($pageRow);
    }
}
