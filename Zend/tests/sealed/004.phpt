--TEST--
Reflection
--FILE--
<?php
sealed class A permits B {}

class B extends A {}

foreach ([A::class, B::class] as $class) {
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
