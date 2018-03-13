<?php

namespace cjohnson\ContentManagementSystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Setting
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="cjohnson\ContentManagementSystemBundle\Entity\SettingRepository")
 */
class Setting
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
     * @ORM\Column(name="bootstrapVersion", type="string", length=10)
     * @Assert\NotBlank()
     */
    private $bootstrapVersion;

    /**
     * @var string
     *
     * @ORM\Column(name="jqueryVersion", type="string", length=10)
     * @Assert\NotBlank()
     */
    private $jqueryVersion;

    /**
     * @var string
     *
     * @ORM\Column(name="bootswatchTemplate", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $bootswatchTemplate;


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
     * Set bootstrapVersion
     *
     * @param string $bootstrapVersion
     *
     * @return Setting
     */
    public function setBootstrapVersion($bootstrapVersion)
    {
        $this->bootstrapVersion = $bootstrapVersion;

        return $this;
    }

    /**
     * Get bootstrapVersion
     *
     * @return string
     */
    public function getBootstrapVersion()
    {
        return $this->bootstrapVersion;
    }

    /**
     * Set bootswatchTemplate
     *
     * @param string $bootswatchTemplate
     *
     * @return Setting
     */
    public function setBootswatchTemplate($bootswatchTemplate)
    {
        $this->bootswatchTemplate = $bootswatchTemplate;

        return $this;
    }

    /**
     * Get bootswatchTemplate
     *
     * @return string
     */
    public function getBootswatchTemplate()
    {
        return $this->bootswatchTemplate;
    }

    /**
     * @return string
     */
    public function getJqueryVersion()
    {
        return $this->jqueryVersion;
    }

    /**
     * @param string $jqueryVersion
     */
    public function setJqueryVersion($jqueryVersion)
    {
        $this->jqueryVersion = $jqueryVersion;
    }
}

