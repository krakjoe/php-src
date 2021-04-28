--TEST--
Reflection
--FILE--
<?php
sealed class A permits B {}
class B extends A {}

interface C permits D {}
interface D extends C {}

trait E permits F {}
class F { use E; }

foreach ([A::class, B::class, C::class, D::class, E::class, F::class] as $class) {
    $reflector = new ReflectionClass($class);

    var_dump($reflector->isSealed());
    var_dump($reflector->getPermittedClasses());
}
?>
--EXPECT--
bool(true)
array(1) {
  [0]=>
  string(1) "B"
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
bool(true)
array(1) {
  [0]=>
  string(1) "F"
}
bool(false)
array(0) {
}
