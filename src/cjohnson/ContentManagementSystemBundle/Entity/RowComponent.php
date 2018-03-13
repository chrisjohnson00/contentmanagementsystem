<?php

namespace cjohnson\ContentManagementSystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RowComponent
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="rc_unique", columns={"component_id","row_id"})})
 * @ORM\Entity(repositoryClass="cjohnson\ContentManagementSystemBundle\Entity\RowComponentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class RowComponent
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
     * @ORM\ManyToOne(targetEntity="Row", inversedBy="rowComponents")
     */
    private $row;

    /**
     * @ORM\ManyToOne(targetEntity="Component", inversedBy="componentRows")
     */
    private $component;

    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer", nullable=true)
     */
    private $rank;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdOn", type="datetime")
     */
    private $createdOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifiedOn", type="datetime")
     */
    private $modifiedOn;

    /**
     * Set row
     *
     * @param integer $row
     *
     * @return RowComponent
     */
    public function setRow($row)
    {
        $this->row = $row;

        return $this;
    }

    /**
     * Get row
     *
     * @return Row
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * Set component
     *
     * @param integer $component
     *
     * @return RowComponent
     */
    public function setComponent($component)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @return Component
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     *
     * @return RowComponent
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return RowComponent
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set modifiedOn
     *
     * @param \DateTime $modifiedOn
     *
     * @return RowComponent
     */
    public function setModifiedOn($modifiedOn)
    {
        $this->modifiedOn = $modifiedOn;

        return $this;
    }

    /**
     * Get modifiedOn
     *
     * @return \DateTime
     */
    public function getModifiedOn()
    {
        return $this->modifiedOn;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedOnValue()
    {
        $this->createdOn  = new \DateTime();
        $this->modifiedOn = new \DateTime();
        $this->rank       = 999;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setModifiedOnValue()
    {
        $this->modifiedOn = new \DateTime();
    }

}
