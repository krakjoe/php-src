--TEST--
Circular Sealing
--FILE--
<?php

sealed class A permits A, B {}

?>
--EXPECTF--
Fatal error: Sealed class A may not permit inheritance for itself in %s/001.php on line %d
