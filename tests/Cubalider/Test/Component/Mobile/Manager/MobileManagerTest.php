<?php

namespace Cubalider\Test\Component\Mobile\Manager;

use Cubalider\Component\Mobile\Manager\MobileManager;
use Cubalider\Component\Mobile\Model\Mobile;
use Doctrine\ORM\EntityManager;
use Yosmanyga\Component\Dql\Fit\Builder;
use Yosmanyga\Component\Dql\Fit\WhereCriteriaFit;

/**
 * @author Yosmany Garcia <yosmanyga@gmail.com>
 * @author Manuel Emilio Carpio <mectwork@gmail.com>
 */
class MobileManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Cubalider\Component\Mobile\Manager\BobileManager::__construct
     */
    public function testConstructor()
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getMockBuilder('Doctrine\ORM\EntityManagerInterface')
            ->getMock();
        /** @var \Yosmanyga\Component\Dql\Fit\Builder $builder */
        $builder = $this->getMockBuilder('Yosmanyga\Component\Dql\Fit\Builder')
            ->setConstructorArgs(array($em))
            ->getMock();
        $manager = new MobileManager($em, $builder);

        $this->assertAttributeEquals($em, 'em', $manager);
        $this->assertAttributeEquals($builder, 'builder', $manager);
    }

    /**
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::__construct
     */
    public function testConstructorWithDefaultParameters()
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getMockBuilder('Doctrine\ORM\EntityManagerInterface')
            ->getMock();
        /** @var \Doctrine\ORM\EntityManager $em */
        $manager = new MobileManager($em);

        $this->assertAttributeEquals(new Builder($em), 'builder', $manager);
    }

    /**
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::add
     */
    public function testAdd()
    {
        $em = $this->getMock('Doctrine\ORM\EntityManagerInterface');
        $mobile = new Mobile();
        /** @var \Doctrine\ORM\EntityManager $em */
        $manager = new MobileManager($em);

        /** @var \PHPUnit_Framework_MockObject_MockObject $em */
        $em
            ->expects($this->once())->method('persist')
            ->with($mobile);
        $em
            ->expects($this->once())->method('flush');

        $manager->add($mobile);
    }

    /**
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::pick
     */
    public function testPick()
    {
        $em = $this->getMock('Doctrine\ORM\EntityManagerInterface');
        $builder = $this->getMockBuilder('Yosmanyga\Component\Dql\Fit\Builder')
            ->disableOriginalConstructor()
            ->getMock();
        $criteria = array('foo' => 'bar');
        $qb = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock();
        $query = $this->getMockBuilder('Doctrine\ORM\AbstractQuery')
            ->disableOriginalConstructor()
            ->setMethods(array('getOneOrNullResult'))
            ->getMockForAbstractClass();
        /** @var \Doctrine\ORM\EntityManager $em */
        /** @var \Yosmanyga\Component\Dql\Fit\Builder $builder */
        $manager = new MobileManager($em, $builder);

        /** @var \PHPUnit_Framework_MockObject_MockObject $builder */
        $builder
            ->expects($this->once())
            ->method('build')
            ->with(
                'Cubalider\Component\Mobile\Model\Mobile',
                new WhereCriteriaFit($criteria)
            )
            ->will($this->returnValue($qb));
        $qb
            ->expects($this->once())
            ->method('getQuery')
            ->will($this->returnValue($query));
        $query
            ->expects($this->once())
            ->method('getOneOrNullResult')
            ->will($this->returnValue('foobar'));

        $this->assertEquals('foobar', $manager->pick($criteria));
    }

    /**
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::pick
     */
    public function testPickWithString()
    {
        $em = $this->getMock('Doctrine\ORM\EntityManagerInterface');
        $builder = $this->getMockBuilder('Yosmanyga\Component\Dql\Fit\Builder')
            ->disableOriginalConstructor()
            ->getMock();
        $criteria = 'foo';
        $qb = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock();
        $query = $this->getMockBuilder('Doctrine\ORM\AbstractQuery')
            ->disableOriginalConstructor()
            ->setMethods(array('getOneOrNullResult'))
            ->getMockForAbstractClass();
        /** @var \Doctrine\ORM\EntityManager $em */
        /** @var \Yosmanyga\Component\Dql\Fit\Builder $builder */
        $manager = new MobileManager($em, $builder);

        /** @var \PHPUnit_Framework_MockObject_MockObject $builder */
        $builder
            ->expects($this->once())
            ->method('build')
            ->with(
                'Cubalider\Component\Mobile\Model\Mobile',
                new WhereCriteriaFit(array('number' => $criteria))
            )
            ->will($this->returnValue($qb));
        $qb
            ->expects($this->once())
            ->method('getQuery')
            ->will($this->returnValue($query));
        $query
            ->expects($this->once())
            ->method('getOneOrNullResult')
            ->will($this->returnValue('foobar'));

        $this->assertEquals('foobar', $manager->pick($criteria));
    }

    /**
     * @covers \Cubalider\Component\Mobile\Manager\MobileManager::remove
     */
    public function testRemove()
    {
        $em = $this->getMock('Doctrine\ORM\EntityManagerInterface');
        $mobile = new Mobile();
        /** @var \Doctrine\ORM\EntityManager $em */
        $manager = new MobileManager($em);

        /** @var \PHPUnit_Framework_MockObject_MockObject $em */
        $em
            ->expects($this->once())->method('remove')
            ->with($mobile);
        $em
            ->expects($this->once())->method('flush');

        $manager->remove($mobile);
    }
}