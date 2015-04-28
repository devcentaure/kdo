<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ZIMZIM\ToolsBundle\Model\APYDataGrid\ApyDataGridFilePathInterface;
use AppBundle\Validator\Constraints as ZimzimAssert;


/**
 * UserKdo
 *
 * @ORM\Table(name="kdoandco_user_kdo")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserKdoRepository")
 *
 * @ZimzimAssert\ConstraintsShareUser
 */
class UserKdo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @GRID\Column(operatorsVisible=false, visible=true, filterable=true, role="ROLE_ADMIN")
     */
    private $id;

    /**
     * @var integer
     *
     * @Assert\NotBlank
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     *
     * @GRID\Column(operatorsVisible=false, visible=true, filterable=true, filter="select",
     * source=true, field="user.username", title="entity.userkdo.user")
     */
    private $user;

    /**
     * @var integer
     *
     * @Assert\NotBlank
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Kdo", inversedBy="usersKdo")
     * @ORM\JoinColumn(name="id_kdo", referencedColumnName="id")
     *
     * @GRID\Column(operatorsVisible=false, visible=true, filterable=true, filter="select",
     * source=true, field="kdo.name", title="entity.userkdo.kdo")
     */
    private $kdo;


    /**
     * @var boolean
     *
     * @ORM\Column(name="auction", type="boolean")
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false)
     *
     */
    private $auction = true;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false)
     */
    private $createdAt;


    /**
     * @var string
     *
     * @Assert\Range(min=0.01, max=999999)
     *
     * @ORM\Column(name="user_share", type="decimal", precision=10, scale=2)
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false)
     */
    private $userShare;


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
     * Set user
     *
     * @param integer $user
     * @return UserKdo
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
     * Set kdo
     *
     * @param integer $kdo
     * @return UserKdo
     */
    public function setKdo($kdo)
    {
        $this->kdo = $kdo;

        return $this;
    }

    /**
     * Get kdo
     *
     * @return integer
     */
    public function getKdo()
    {
        return $this->kdo;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return UserKdo
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

    /**
     * Set userShare
     *
     * @param string $userShare
     * @return UserKdo
     */
    public function setUserShare($userShare)
    {
        $this->userShare = $userShare;

        return $this;
    }

    /**
     * Get userShare
     *
     * @return string
     */
    public function getUserShare()
    {
        return $this->userShare;
    }

    /**
     * @param boolean $auction
     */
    public function setAuction($auction)
    {
        $this->auction = $auction;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getAuction()
    {
        return $this->auction;
    }
}
