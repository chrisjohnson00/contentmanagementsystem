<?php

namespace cjohnson\ContentManagementSystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PageRow
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="pr_unique", columns={"page_id","row_id"})})
 * @ORM\Entity(repositoryClass="cjohnson\ContentManagementSystemBundle\Entity\PageRowRepository")
 * @ORM\HasLifecycleCallbacks()

 *
 */
class PageRow
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
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="pageRows")
     */
    private $page;

    /**
     * @ORM\ManyToOne(targetEntity="Row", inversedBy="rowPages")
     */
    private $row;

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
     * Set page
     *
     * @param integer $page
     *
     * @return PageRow
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set row
     *
     * @param integer $row
     *
     * @return PageRow
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
     * Set rank
     *
     * @param integer $rank
     *
     * @return PageRow
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
     * @return PageRow
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
     * @return PageRow
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
     * @ORM\PrePersist
     */
    public function setCreatedOnValue()
    {
        $this->createdOn  = new \DateTime();
        $this->modifiedOn = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setModifiedOnValue()
    {
        $this->modifiedOn = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
