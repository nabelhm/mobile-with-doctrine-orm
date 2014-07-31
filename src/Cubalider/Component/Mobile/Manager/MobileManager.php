<?php

namespace Cubalider\Component\Mobile\Manager;

use Cubalider\Component\Mobile\Model\Mobile;
use Doctrine\ORM\EntityManagerInterface;
use Yosmanyga\Component\Dql\Fit\Builder;
use Yosmanyga\Component\Dql\Fit\WhereCriteriaFit;

/**
 * @author Yosmany Garcia <yosmanyga@gmail.com>
 */
class MobileManager implements MobileManagerInterface
{
    /**
     * @var string
     */
    private $class = 'Cubalider\Component\Mobile\Model\Mobile';

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * @var Builder;
     */
    private $builder;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $em
     * @param Builder $builder
     */
    public function __construct(EntityManagerInterface $em, Builder $builder = null)
    {
        $this->em = $em;
        $this->builder = $builder ? : new Builder($em);
    }

    /**
     * Adds given mobile.
     *
     * @param Mobile $mobile
     */
    public function add(Mobile $mobile)
    {
        $this->em->persist($mobile);
        $this->em->flush();
    }

    /**
     * Picks a mobile using given criteria.
     *
     * @param mixed $criteria
     *
     * @return Mobile|null The mobile or null if nothing is found
     */
    public function pick($criteria)
    {
        if (is_string($criteria)) {
            $criteria = array('number' => $criteria);
        }
        $qb = $this->builder->build(
            $this->class,
            new WhereCriteriaFit($criteria)
        );

        return $qb
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Removes given mobile.
     *
     * @param Mobile $mobile
     */
    public function remove($mobile)
    {
        $this->em->remove($mobile);
        $this->em->flush();
    }
}