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
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserListKdoRepository")
 */
class UserListKdo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false)
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
     * @GRID\Column(operatorsVisible=false, filter="select",field="listKdo.name", source=true, title="entity.userlistkdo.listkdo")
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
     *
     * @GRID\Column(operatorsVisible=false, visible=true, filterable=true, filter="select",
     * source=true, field="user.username", title="entity.userlistkdo.user")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @GRID\Column(operatorsVisible=false, visible=true, filterable=false, title="entity.userlistkdo.date")
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
