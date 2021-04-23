--TEST--
Circular Friendship
--FILE--
<?php
class A for A,B {}
?>
--EXPECTF--
Fatal error: Class A may not be friends with itself in %s/001.php on line %d
