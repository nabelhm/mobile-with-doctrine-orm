<?php

namespace Muchacuba\Test\Component\Mobile\Entity;

use Muchacuba\Component\Mobile\Entity\Mobile;

/**
 * @author Yosmany Garcia <yosmanyga@gmail.com>
 */
class MobileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Muchacuba\Component\Mobile\Entity\Mobile::getId
     */
    public function testId()
    {
        $mobile = new Mobile();
        $this->assertNull($mobile->getId());
    }

    /**
     * @covers \Muchacuba\Component\Mobile\Entity\Mobile::setNumber
     * @covers \Muchacuba\Component\Mobile\Entity\Mobile::getNumber
     */
    public function testNumber()
    {
        $mobile = new Mobile();
        $this->assertNull($mobile->getNumber());

        $mobile->setNumber('123');
        $this->assertEquals('123', $mobile->getNumber());
    }
}