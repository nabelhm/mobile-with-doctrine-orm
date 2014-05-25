<?php

namespace Muchacuba\Component\Mobile\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Yosmany Garcia <yosmanyga@gmail.com>
 * @ORM\Entity
 */
class Mobile implements MobileInterface 
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column()
     */
    protected $number;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }
}