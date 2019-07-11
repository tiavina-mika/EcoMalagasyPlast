<?php

namespace App\CoreBundle\Entity;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\CoreBundle\Entity\Abstracts\Media as Media;

/**
 * @Vich\Uploadable
 */
class UtilisateurImage extends Media
{
     /**
    * @Vich\UploadableField(mapping="utilisateur_image", fileNameProperty="name")
    */
    public $file;
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \DateTime
     */
    protected $updatedAt;


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
     * @return UtilisateurImage
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return UtilisateurImage
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
