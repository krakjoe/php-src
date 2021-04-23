--TEST--
Circular Friendship Interface
--FILE--
<?php
interface A for A,B {}
?>
--EXPECTF--
Fatal error: Interface A may not be friends with itself in %s/006.php on line %d
