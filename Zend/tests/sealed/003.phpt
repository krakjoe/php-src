--TEST--
Not permitted class
--FILE--
<?php
sealed class A permits B {}

class B extends A {} // ok

class C extends A {} // ko
?>
--EXPECTF--
Fatal error: Class C is not permitted to inherit from A in %s/003.php on line %d

