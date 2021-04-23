--TEST--
Circular Friendship Parent
--FILE--
<?php
class A for B {}

class B for A extends A {}
?>
--EXPECTF--
Fatal error: Class B may not be friends with parent A in %s/002.php on line %d
