--TEST--
Circular Friendship Parent Interface
--FILE--
<?php
interface A for B {}

interface B for A extends A {}
?>
--EXPECTF--
Fatal error: Interface B may not be friends with parent A in %s/007.php on line %d
