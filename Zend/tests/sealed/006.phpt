--TEST--
Circular Sealing Interface
--FILE--
<?php
sealed interface A permits A, B {}
?>
--EXPECTF--
Fatal error: Sealed interface A may not permit inheritance for itself in %s/001.php on line %d
