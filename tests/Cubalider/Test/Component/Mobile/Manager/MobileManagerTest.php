<?php

namespace Cubalider\Test\Component\Mobile\Manager;

use Cubalider\Component\Mobile\Manager\MobileManager;
use Cubalider\Test\Component\Mobile\EntityManagerBuilder;
use Cubalider\Component\Mobile\Model\Mobile;
use Doctrine\ORM\EntityManager;

/**
 * @author Yosmany Garcia <yosmanyga@gmail.com>
 */
class MobileManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManager
     */
    protected $em;

    public function setUp()
    {
        $builder = new EntityManagerBuilder();
        $this->em = $builder->createEntityManager(
            array(
                sprintf("%s/../../../../../../src/Cubalider/Component/Mobile/Resources/config/doctrine", __DIR__),
            ),
            array(
                'Cubalider\Component\Mobile\Model\Mobile',
            )
        );
    }

    /**
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::__construct
     */
    public function testConstructor()
    {
        $manager = new MobileManager($this->em);

        $this->assertAttributeEquals($this->em, 'em', $manager);
        $this->assertAttributeEquals($this->em->getRepository('Cubalider\Component\Mobile\Model\Mobile'), 'repository', $manager);
    }

    /**
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::add
     */
    public function testAdd()
    {
        /* Fixtures */

        $mobile1 = new Mobile();
        $mobile1->setNumber('123');

        /* Tests */

        $manager = new MobileManager($this->em);
        $manager->add($mobile1);

        $repository = $this->em->getRepository('Cubalider\Component\Mobile\Model\Mobile');

        $this->assertEquals(1, count($repository->findAll()));
    }

    /**
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::pick
     */
    public function testPick()
    {
        /* Fixtures */

        $mobile1 = new Mobile();
        $mobile1->setNumber('123');
        $this->em->persist($mobile1);
        $mobile2 = new Mobile();
        $mobile2->setNumber('456');
        $this->em->persist($mobile2);
        $this->em->flush();

        /* Tests */

        $manager = new MobileManager($this->em);
        $this->assertEquals($mobile2, $manager->pick('456'));

        $manager = new MobileManager($this->em);
        $this->assertEquals($mobile2, $manager->pick(array('number' => '456')));
    }

    /**
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::remove
     */
    public function testRemove()
    {
        /* Fixtures */

        $mobile1 = new Mobile();
        $mobile1->setNumber('123');
        $this->em->persist($mobile1);
        $mobile2 = new Mobile();
        $mobile2->setNumber('456');
        $this->em->persist($mobile2);
        $this->em->flush();

        /* Tests */

        $manager = new MobileManager($this->em);
        $manager->remove($mobile1);

        $repository = $this->em->getRepository('Cubalider\Component\Mobile\Model\Mobile');

        $this->assertEquals(1, count($repository->findAll()));
    }
}