<?php

namespace Cubalider\Component\Mobile\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Cubalider\Component\Mobile\Model\MobileInterface;
use Cubalider\Component\Mobile\Entity\MobileInterface as EntityMobileInterface;

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
     * @var string
     */
    private $class;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    /**
     * Constructor
     *
     * Additionally it creates a repository using $em, for given class
     *
     * @param EntityManagerInterface $em
     * @param string                 $class
     */
    public function __construct(
        EntityManagerInterface $em,
        $class = 'Cubalider\Component\Mobile\Entity\Mobile'
    )
    {
        $this->em = $em;
        $this->class = $em->getClassMetadata($class)->getName();
        $this->repository = $this->em->getRepository($class);
    }

    /**
     * @inheritdoc
     */
    public function add(MobileInterface $mobile)
    {
        /** @var EntityMobileInterface $mobileEntity */
        $mobileEntity = new $this->class;
        $mobileEntity->setNumber($mobile->getNumber());

        $this->em->persist($mobileEntity);
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
        $this->validate($mobile);

        $this->em->remove($mobile);
        $this->em->flush();
    }

    /**
     * Validates if given object is an instance of the supported class
     *
     * @param $mobile
     * @throws \InvalidArgumentException if given object is not an instance of
     *                                   the supported class
     * @return void
     */
    private function validate($mobile)
    {
        if (!$mobile instanceof $this->class) {
            throw new \InvalidArgumentException(sprintf("Invalid object, it must be an instance of %s", $this->class));
        }
    }
}