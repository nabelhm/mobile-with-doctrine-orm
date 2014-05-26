<?php

namespace Cubalider\Test\Component\Mobile\Entity;

use Cubalider\Component\Mobile\Entity\Mobile;

/**
 * @author Yosmany Garcia <yosmanyga@gmail.com>
 */
class MobileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Cubalider\Component\Mobile\Entity\Mobile::getId
     */
    public function testId()
    {
        $mobile = new Mobile();
        $this->assertNull($mobile->getId());
    }

    /**
     * @covers \Cubalider\Component\Mobile\Entity\Mobile::setNumber
     * @covers \Cubalider\Component\Mobile\Entity\Mobile::getNumber
     */
    public function testNumber()
    {
        $mobile = new Mobile();
        $this->assertNull($mobile->getNumber());

        $mobile->setNumber('123');
        $this->assertEquals('123', $mobile->getNumber());
    }
}