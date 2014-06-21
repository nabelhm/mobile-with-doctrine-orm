<?php

namespace Cubalider\Component\Mobile\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Cubalider\Component\Mobile\Model\Mobile;

/**
 * @author Yosmany Garcia <yosmanyga@gmail.com>
 */
class MobileManager implements MobileManagerInterface
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    /**
     * Constructor
     *
     * Additionally it creates a repository using $em, for entity class
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('Cubalider\Component\Mobile\Model\Mobile');
    }

    /**
     * @inheritdoc
     */
    public function add(Mobile $mobile)
    {
        $this->em->persist($mobile);
        $this->em->flush();
    }

    /**
     * @inheritdoc
     */
    public function pick($criteria)
    {
        if (is_string($criteria)) {
            $criteria = array('number' => $criteria);
        }

        return $this->repository->findOneBy($criteria);
    }

    /**
     * @inheritdoc
     */
    public function remove($mobile)
    {
        $this->em->remove($mobile);
        $this->em->flush();
    }
}