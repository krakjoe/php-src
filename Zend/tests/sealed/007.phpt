--TEST--
Circular Friendship Parent Interface
--FILE--
<?php
sealed interface A permits B {}

sealed interface B extends A permits A {}
?>
--EXPECTF--
Fatal error: Sealed interface B may not permit inheritance from its parent A in %s/002.php on line %d
