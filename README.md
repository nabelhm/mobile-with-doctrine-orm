Muchacuba Mobile
================

This library is an implementation of `cubalider/mobile` using `doctrine/orm` for
persistence.

```
// $em is an already created entity manager

$manager = new MobileManager($em);

$mobile1 = new Mobile();
$mobile1->setNumber('123');
$manager->add($mobile1);

$mobile2 = new Mobile();
$mobile2->setNumber('456');
$manager->add($mobile2);

$mobile = $manager->pick('456');
```
