<?php

namespace AppBundle\Entity\Repository;

use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityRepository;
use ZIMZIM\ToolsBundle\Model\APYDataGrid\ApyDataGridRepositoryInterface;

/**
 * ListKdoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ListKdoRepository extends EntityRepository implements ApyDataGridRepositoryInterface
{
    public function getList(Entity $source)
    {
        return $source;
    }

    public function getListByDate(\DateTime $date)
    {
        $query = $this->createQueryBuilder('lk');

        $query->where('lk.date >= :date')
            ->setParameter('date', $date->format('Y-m-d'))
            ->orderBy('lk.date', 'DESC');

        return $query->getQuery()->getResult();
    }
}