<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ZIMZIM\ToolsBundle\Model\APYDataGrid\ApyDataGridFilePathInterface;
use ZIMZIM\ToolsBundle\Model\FileUpload;


/**
 * ListKdo
 *
 * @ORM\Table(name="kdoandco_list_kdo")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ListKdoRepository")
 * @UniqueEntity("slug")
 */
class ListKdo extends FileUpload implements ApyDataGridFilePathInterface
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
     * @var string
     *
     * @Assert\NotBlank
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @GRID\Column(operatorsVisible=false, filter="select", source=true, title="entity.listkdo.name")
     */
    private $name;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern="/^[a-z\-]+$/",
     *     message="entity.listkdo.slug"
     * )
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false)
     */
    private $slug;

    /**
     * @var integer
     *
     * @Assert\NotBlank
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     *
     * @GRID\Column(operatorsVisible=false, visible=true, filterable=true, filter="select",
     * source=true, field="user.username", title="entity.listkdo.user")
     */
    private $user;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     *
     * @GRID\Column(operatorsVisible=false, visible=true, filterable=false, title="entity.listkdo.date")
     */
    private $date;


    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @GRID\Column(operatorsVisible=false, visible=true, filterable=false, title="entity.listkdo.createdat")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @Assert\NotBlank
     *
     * @ORM\Column(name="password", type="string", length=255)
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false)
     */
    private $password;

    /******************************* FILE ***********************************/


    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'resources/listkdo';
    }


    public function getListAttrImg()
    {
        return array('icon', 'picture');
    }
    /******************************* END FILE ***********************************/

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
     * @return ListKdo
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
     * Set user
     *
     * @param integer $user
     * @return ListKdo
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
     * @return ListKdo
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
     * Set password
     *
     * @param string $password
     * @return ListKdo
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }


}
