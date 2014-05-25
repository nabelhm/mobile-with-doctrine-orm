<?php

namespace Muchacuba\Test\Component\Mobile\Manager;

use Muchacuba\Component\Mobile\Manager\MobileManager;
use Muchacuba\Test\Component\Mobile\EntityManagerBuilder;
use Muchacuba\Component\Mobile\Entity\Mobile;
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
                'Muchacuba\Component\Mobile\Entity\Mobile',
            ),
            array(),
            array(
                'Muchacuba\Component\Mobile\Entity\MobileInterface' => 'Muchacuba\Component\Mobile\Entity\Mobile',
            )
        );
    }

    /**
     * @covers \Muchacuba\Component\Mobile\Manager\MobileManager::__construct
     */
    public function testConstructor()
    {
        $class = 'Muchacuba\Component\Mobile\Entity\Mobile';
        $metadata = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $metadata->expects($this->once())->method('getName')->will($this->returnValue($class));
        $em = $this->getMock('Doctrine\ORM\EntityManagerInterface');
        $em->expects($this->once())->method('getClassMetadata')->with($class)->will($this->returnValue($metadata));
        /** @var \Doctrine\ORM\EntityManagerInterface $em */
        $manager = new MobileManager($em, $class);

        $this->assertAttributeEquals($em, 'em', $manager);
        $this->assertAttributeEquals($class, 'class', $manager);
        $this->assertAttributeEquals($em->getRepository('Muchacuba\Component\Mobile\Entity\Mobile'), 'repository', $manager);
    }
    
    /**
     * @covers \Muchacuba\Component\Mobile\Manager\MobileManager::pick
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
        $this->assertEquals($mobile2, $manager->pick(array('number' => '456')));
    }

    /**
     * @covers \Muchacuba\Component\Mobile\Manager\MobileManager::add
     */
    public function testAdd()
    {
        /* Fixtures */

        $mobile1 = new Mobile();
        $mobile1->setNumber('123');

        /* Tests */

        $manager = new MobileManager($this->em);
        $manager->add($mobile1);

        $repository = $this->em->getRepository('Muchacuba\Component\Mobile\Entity\Mobile');

        $this->assertEquals(1, count($repository->findAll()));
    }

    /**
     * @covers \Muchacuba\Component\Mobile\Manager\MobileManager::add
     * @expectedException \InvalidArgumentException
     */
    public function testAddWithInvalidObject()
    {
        $manager = new MobileManager($this->em);
        $manager->add(new \stdClass());
    }

    /**
     * @covers \Muchacuba\Component\Mobile\Manager\MobileManager::add
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

        $repository = $this->em->getRepository('Muchacuba\Component\Mobile\Entity\Mobile');

        $this->assertEquals(1, count($repository->findAll()));
    }

    /**
     * @covers \Muchacuba\Component\Mobile\Manager\MobileManager::remove
     * @expectedException \InvalidArgumentException
     */
    public function testRemoveWithInvalidObject()
    {
        $manager = new MobileManager($this->em);
        $manager->remove(new \stdClass());
    }
}