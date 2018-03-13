<?php

namespace cjohnson\ContentManagementSystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Row
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="cjohnson\ContentManagementSystemBundle\Entity\RowRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class Row
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
     * @var \DateTime
     *
     * @ORM\Column(name="createdDate", type="datetime")
     */
    private $createdDate;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="PageRow", mappedBy="row")
     */
    private $rowPages;

    /**
     * @ORM\OneToMany(targetEntity="RowComponent", mappedBy="row")
     */
    private $rowComponents;

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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Row
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
        $this->createdDate = new \DateTime();
    }

    /**
     * @return \cjohnson\ContentManagementSystemBundle\Entity\PageRow[]
     */
    public function getRowPages()
    {
        return $this->rowPages;
    }

    /**
     * @param mixed $rowPages
     */
    public function setRowPages($rowPages)
    {
        $this->rowPages = $rowPages;
    }

    /**
     * @return \cjohnson\ContentManagementSystemBundle\Entity\RowComponent[]
     */
    public function getRowComponents()
    {
        return $this->rowComponents;
    }

    /**
     * @param mixed $rowComponents
     */
    public function setRowComponents($rowComponents)
    {
        $this->rowComponents = $rowComponents;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rowPages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rowComponents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add rowPage
     *
     * @param \cjohnson\ContentManagementSystemBundle\Entity\PageRow $rowPage
     *
     * @return Row
     */
    public function addRowPage(\cjohnson\ContentManagementSystemBundle\Entity\PageRow $rowPage)
    {
        $this->rowPages[] = $rowPage;

        return $this;
    }

    /**
     * Remove rowPage
     *
     * @param \cjohnson\ContentManagementSystemBundle\Entity\PageRow $rowPage
     */
    public function removeRowPage(\cjohnson\ContentManagementSystemBundle\Entity\PageRow $rowPage)
    {
        $this->rowPages->removeElement($rowPage);
    }

    /**
     * Add rowComponent
     *
     * @param \cjohnson\ContentManagementSystemBundle\Entity\RowComponent $rowComponent
     *
     * @return Row
     */
    public function addRowComponent(\cjohnson\ContentManagementSystemBundle\Entity\RowComponent $rowComponent)
    {
        $this->rowComponents[] = $rowComponent;

        return $this;
    }

    /**
     * Remove rowComponent
     *
     * @param \cjohnson\ContentManagementSystemBundle\Entity\RowComponent $rowComponent
     */
    public function removeRowComponent(\cjohnson\ContentManagementSystemBundle\Entity\RowComponent $rowComponent)
    {
        $this->rowComponents->removeElement($rowComponent);
    }
}
