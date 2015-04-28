<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ZIMZIM\ToolsBundle\Model\APYDataGrid\ApyDataGridFilePathInterface;

/**
 * Kdo
 *
 * @ORM\Table(name="kdoandco_kdo")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\KdoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Kdo implements ApyDataGridFilePathInterface
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
     * @var string
     *
     * @Assert\NotBlank
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @GRID\Column(operatorsVisible=false, filter="select", source=true, title="entity.kdo.name")
     *
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
     * @var integer
     *
     * @Assert\NotBlank
     * @Assert\Range(min=1, max=999)
     *
     * @ORM\Column(name="quantity", type="integer")
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false)
     */
    private $quantity = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false)
     */
    private $link;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @Assert\Range(min=0.01, max=999999)
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     *
     * @GRID\Column(operatorsVisible=false, filter="select", source=true, title="entity.kdo.price")
     */
    private $price;


    /**
     * @var string
     *
     * @Assert\NotBlank
     * @Assert\Range(min=0, max=999999)
     *
     * @ORM\Column(name="forecast", type="decimal", precision=10, scale=2)
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false )
     */
    private $forecast;


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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ListKdo", inversedBy="kdos")
     * @ORM\JoinColumn(name="id_listkdo", referencedColumnName="id")
     *
     * @GRID\Column(operatorsVisible=false, visible=true, filterable=true, filter="select",
     * source=true, field="listkdo.name", title="entity.kdo.listkdo")
     */
    private $listkdo;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserKdo", mappedBy="kdo", cascade={"persist", "remove"})
     */
    private $usersKdo;


    public function __construct(){
        $this->usersKdo = new ArrayCollection();
    }




    /******************************* FILE ***********************************/


    /**
     * @Assert\File(maxSize="200000", mimeTypes={"image/jpeg", "image/png", "image/gif"})
     */
    private $fileIcon;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="icon")
     *
     * @GRID\Column(operatorsVisible=false, safe=false, filterable=false, sortable=false, title="entity.listkdo.icon")
     */
    private $icon;

    public function getAbsoluteIcon()
    {
        return null === $this->icon ? null : $this->getUploadRootDir() . '/' . $this->icon;
    }

    public function getWebIcon()
    {
        return null === $this->icon ? null : $this->getUploadDir().'/'.$this->icon;
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'resources/kdo';
    }

    public function getListAttrImg()
    {
        return array('icon');
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (isset($this->fileIcon)) {
            if (null !== $this->fileIcon) {
                $oldFile = $this->getAbsoluteIcon();
                if ($oldFile && isset($this->fileIcon) && isset($this->icon)) {
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                $this->icon = sha1(uniqid(mt_rand(), true)) . '.' . $this->fileIcon->guessExtension();
            }
        }

    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (isset($this->fileIcon)) {
            if (null === $this->fileIcon) {
                return;
            }
            $this->fileIcon->move($this->getUploadRootDir(), $this->icon);
            unset($this->fileIcon);
        }

    }


    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (isset($this->icon) && $file = $this->getAbsoluteIcon()) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
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
     * @return Kdo
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
     * Set description
     *
     * @param string $description
     * @return Kdo
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Kdo
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Kdo
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Kdo
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Kdo
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
     * Set listkdo
     *
     * @param integer $listkdo
     * @return Kdo
     */
    public function setListkdo($listkdo)
    {
        $this->listkdo = $listkdo;

        return $this;
    }

    /**
     * Get listkdo
     *
     * @return integer 
     */
    public function getListkdo()
    {
        return $this->listkdo;
    }

    /**
     * @return mixed
     */
    public function getFileIcon()
    {
        return $this->fileIcon;
    }

    /**
     * @param mixed $fileIcon
     */
    public function setFileIcon($fileIcon)
    {
        $this->fileIcon = $fileIcon;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $usersKdo
     */
    public function setUsersKdo($usersKdo)
    {
        $this->usersKdo = $usersKdo;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getUsersKdo()
    {
        return $this->usersKdo;
    }

    /**
     * @param string $forecast
     */
    public function setForecast($forecast)
    {
        $this->forecast = $forecast;

        return $this;
    }

    /**
     * @return string
     */
    public function getForecast()
    {
        return $this->forecast;
    }
}
