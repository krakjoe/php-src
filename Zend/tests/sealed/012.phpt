--TEST--
Implementing sealed interfaces
--FILE--
<?php
sealed interface A permits C, D {}

class C implements A {} // OK
class D implements A {} // OK

interface E extends A {} // OK

interface F extends E {} // OK

class G extends C implements E {} // OK
class H extends D implements E {} // OK

class I extends C implements F {} // OK
class J extends D implements F {} // OK

// F extends E - E extends A - A permits implementations only for C, and D
class K implements F {} // K.O
?>
--EXPECT--
Fatal error: Class K cannot implement sealed interface A in %s/012.php on line %d
