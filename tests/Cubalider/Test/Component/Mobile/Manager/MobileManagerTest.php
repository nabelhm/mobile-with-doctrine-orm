<?php

namespace Cubalider\Test\Component\Mobile\Manager;

use Cubalider\Component\Mobile\Manager\MobileManager;
use Cubalider\Test\Component\Mobile\EntityManagerBuilder;
use Cubalider\Component\Mobile\Entity\Mobile;
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
                'Cubalider\Component\Mobile\Entity\Mobile',
            ),
            array(),
            array(
                'Cubalider\Component\Mobile\Entity\MobileInterface' => 'Cubalider\Component\Mobile\Entity\Mobile',
            )
        );
    }

    /**
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::__construct
     */
    public function testConstructor()
    {
        $class = 'Cubalider\Component\Mobile\Entity\Mobile';
        $metadata = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $metadata->expects($this->once())->method('getName')->will($this->returnValue($class));
        $em = $this->getMock('Doctrine\ORM\EntityManagerInterface');
        $em->expects($this->once())->method('getClassMetadata')->with($class)->will($this->returnValue($metadata));
        /** @var \Doctrine\ORM\EntityManagerInterface $em */
        $manager = new MobileManager($em, $class);

        $this->assertAttributeEquals($em, 'em', $manager);
        $this->assertAttributeEquals($class, 'class', $manager);
        $this->assertAttributeEquals($em->getRepository('Cubalider\Component\Mobile\Entity\Mobile'), 'repository', $manager);
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
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::add
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::validate
     */
    public function testAdd()
    {
        /* Fixtures */

        $mobile1 = new Mobile();
        $mobile1->setNumber('123');

        /* Tests */

        $manager = new MobileManager($this->em);
        $manager->add($mobile1);

        $repository = $this->em->getRepository('Cubalider\Component\Mobile\Entity\Mobile');

        $this->assertEquals(1, count($repository->findAll()));
    }

    /**
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::add
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::validate
     * @expectedException \InvalidArgumentException
     */
    public function testAddWithInvalidObject()
    {
        $manager = new MobileManager($this->em);
        $manager->add(new \stdClass());
    }

    /**
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::remove
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::validate
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

        $repository = $this->em->getRepository('Cubalider\Component\Mobile\Entity\Mobile');

        $this->assertEquals(1, count($repository->findAll()));
    }

    /**
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::remove
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::validate
     * @expectedException \InvalidArgumentException
     */
    public function testRemoveWithInvalidObject()
    {
        $manager = new MobileManager($this->em);
        $manager->remove(new \stdClass());
    }
}