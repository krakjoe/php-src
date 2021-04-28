--TEST--
Sealing Inheritance
--FILE--
<?php
sealed class A permits B, C {}

sealed class B extends A permits C {}

class C extends B {}

class D {}

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
bool(true)
array(1) {
  [0]=>
  string(1) "C"
}
bool(false)
array(0) {
}
bool(false)
array(0) {
}

