<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Kdo;
use Doctrine\ORM\EntityRepository;
use ZIMZIM\ToolsBundle\Model\APYDataGrid\ApyDataGridRepositoryInterface;
use APY\DataGridBundle\Grid\Source\Entity;

/**
 * UserKdoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserKdoRepository extends EntityRepository implements ApyDataGridRepositoryInterface
{
    public function getList(Entity $source)
    {
        return $source;
    }
}
