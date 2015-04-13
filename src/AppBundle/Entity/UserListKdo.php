<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use APY\DataGridBundle\Grid\Mapping as GRID;


/**
 * UserListKdo
 *
 * @ORM\Table(name="kdoandco_user_list_kdo")
 * @ORM\Entity
 */
class UserListKdo
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
     * @var integer
     *
     * @Assert\NotBlank
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ListKdo")
     * @ORM\JoinColumn(name="id_list_kdo", referencedColumnName="id")
     *
     */
    private $listKdo;

    /**
     * @var integer
     *
     * @Assert\NotBlank
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


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
     * Set listKdo
     *
     * @param integer $listKdo
     * @return UserListKdo
     */
    public function setListKdo($listKdo)
    {
        $this->listKdo = $listKdo;

        return $this;
    }

    /**
     * Get listKdo
     *
     * @return integer 
     */
    public function getListKdo()
    {
        return $this->listKdo;
    }

    /**
     * Set user
     *
     * @param integer $user
     * @return UserListKdo
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return integer 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return UserListKdo
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
