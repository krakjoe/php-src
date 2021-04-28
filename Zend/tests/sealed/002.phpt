--TEST--
Circular Sealing Parent
--FILE--
<?php

sealed class A permits B {}

sealed class B extends A permits A {}
?>
--EXPECTF--
Fatal error: Sealed class B may not permit inheritance from its parent A in %s/002.php on line %d
