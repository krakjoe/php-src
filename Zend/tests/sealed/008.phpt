--TEST--
Not permitted class
--FILE--
<?php
sealed interface A permits B {}

final class C implements A {}
?>
--EXPECTF--
Fatal error: Class C cannot implement sealed interface A in %s/008.php on line %d
