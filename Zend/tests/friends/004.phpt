--TEST--
Friendship
--FILE--
<?php
class A for B {}

class B extends A {}

foreach ([A::class, B::class] as $class) {
    $reflector = new ReflectionClass($class);
    
    var_dump($reflector->getFriendNames());
}
?>
--EXPECT--
array(1) {
  [0]=>
  string(1) "B"
}
array(0) {
}
