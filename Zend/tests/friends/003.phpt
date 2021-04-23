--TEST--
No Friendship
--FILE--
<?php
class A for B {}

class C extends A {}
?>
--EXPECTF--
Fatal error: Class C is not a friend of A in %s/003.php on line %d

