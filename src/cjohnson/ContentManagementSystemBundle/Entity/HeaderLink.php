<?php

namespace cjohnson\ContentManagementSystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use cjohnson\ContentManagementSystemBundle\Entity\Page;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * HeaderLink
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="cjohnson\ContentManagementSystemBundle\Entity\HeaderLinkRepository")
 */
class HeaderLink
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
     * @var Page
     *
     * @ORM\OneToOne(targetEntity="Page")
     */
    private $page;

    /**
     * @var integer
     *
     * @ORM\Column(name="sortOrder", type="integer")
     * @Assert\NotBlank()
     */
    private $sortOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="LinkText", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $linkText;

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
     * Set sortOrder
     *
     * @param integer $sortOrder
     *
     * @return HeaderLink
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * Get sortOrder
     *
     * @return integer
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * Set linkText
     *
     * @param string $linkText
     *
     * @return HeaderLink
     */
    public function setLinkText($linkText)
    {
        $this->linkText = $linkText;

        return $this;
    }

    /**
     * Get linkText
     *
     * @return string
     */
    public function getLinkText()
    {
        return $this->linkText;
    }

    /**
     * Set page
     *
     * @param \cjohnson\ContentManagementSystemBundle\Entity\Page $page
     *
     * @return HeaderLink
     */
    public function setPage(\cjohnson\ContentManagementSystemBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \cjohnson\ContentManagementSystemBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }
}
