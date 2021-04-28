--TEST--
Sealing Inheritance Interfaces
--FILE--
<?php
sealed interface A permits B, C {}

interface B extends A {}

sealed interface C extends A permits D {}

interface D extends B, C {}

foreach ([A::class, B::class, C::class, D::class] as $class) {
    $reflector = new ReflectionClass($class);

    var_dump($reflector->isSealed());
    var_dump($reflector->getPermittedClasses());
}
?>
--EXPECT--
bool(true)
array(2) {
  [0]=>
  string(1) "B"
  [1]=>
  string(1) "C"
}
bool(false)
array(0) {
}
bool(true)
array(1) {
  [0]=>
  string(1) "D"
}
bool(false)
array(0) {
}
