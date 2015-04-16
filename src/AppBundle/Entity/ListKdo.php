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
 * ListKdo
 *
 * @ORM\Table(name="kdoandco_list_kdo")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ListKdoRepository")
 * @UniqueEntity("slug")
 * @ORM\HasLifecycleCallbacks
 */
class ListKdo implements ApyDataGridFilePathInterface
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
     * @ORM\Column(name="helppass", type="string", length=255)
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false)
     */
    private $helppass;


    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false)
     */
    private $password;

    /******************************* FILE ***********************************/

    /**
     * @Assert\File(maxSize="100000", mimeTypes={"image/jpeg", "image/png", "image/gif"})
     */
    public $fileIcon;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="icon")
     *
     * @GRID\Column(operatorsVisible=false, safe=false, filterable=false, sortable=false, title="entity.listkdo.icon")
     */
    protected $icon;

    public function getAbsoluteIcon()
    {
        return null === $this->icon ? null : $this->getUploadRootDir() . '/' . $this->icon;
    }

    public function getWebIcon()
    {
        return null === $this->icon ? null : $this->getUploadDir().'/'.$this->icon;
    }

    /**
     * @Assert\File(maxSize="500000", mimeTypes={"image/jpeg", "image/png", "image/gif"})
     */
    public $filePicture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="picture")
     *
     * @GRID\Column(operatorsVisible=false, filterable=false, sortable=false, safe=false, title="entity.listkdo.picture")
     */
    protected $picture;

    public function getAbsolutePicture()
    {
        return null === $this->icon ? null : $this->getUploadRootDir() . '/' . $this->picture;
    }

    public function getWebPicture()
    {
        return null === $this->icon ? null : $this->getUploadDir().'/'.$this->picture;
    }


    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'resources/listkdo';
    }


    public function getListAttrImg()
    {
        return array('icon', 'picture');
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
                usleep(1);
            }
        }

        if (isset($this->filePicture)) {
            if (null !== $this->filePicture) {
                $oldFile = $this->getAbsolutePicture();
                if ($oldFile && isset($this->filePicture) && isset($this->picture)) {
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                $this->picture = sha1(uniqid(mt_rand(), true)) . '.' . $this->filePicture->guessExtension();
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

        if (isset($this->filePicture)) {
            if (null === $this->filePicture) {
                return;
            }
            $this->filePicture->move($this->getUploadRootDir(), $this->picture);
            unset($this->filePicture);
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
        if (isset($this->picture) && $file = $this->getAbsolutePicture()) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    /******************************* END FILE ***********************************/


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Kdo", mappedBy="listkdo", cascade={"persist", "remove"})
     */
    private $kdos;


    public function __construct()
    {
        $this->kdos = new ArrayCollection();
    }


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

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }


    public function __toString(){
        return $this->name;
    }

    /**
     * @return ArrayCollection
     */
    public function getKdos()
    {
        return $this->kdos;
    }

    /**
     * @param ArrayCollection $kdos
     */
    public function setKdos($kdos)
    {
        $this->kdos = $kdos;

        return $this;
    }

    /**
     * @return string
     */
    public function getHelppass()
    {
        return $this->helppass;
    }

    /**
     * @param string $helppass
     */
    public function setHelppass($helppass)
    {
        $this->helppass = $helppass;

        return $this;
    }

}
