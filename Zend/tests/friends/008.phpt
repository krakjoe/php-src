--TEST--
No Friendship Interface
--FILE--
<?php
interface A for B {}

class C implements A {}
?>
--EXPECTF--
Fatal error: Class C is not a friend of A in %s/008.php on line %d
