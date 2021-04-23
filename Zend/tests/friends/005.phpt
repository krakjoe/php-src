--TEST--
Friendship Inheritance
--FILE--
<?php
class A for B,C {}

class B extends A {}

foreach ([A::class, B::class] as $class) {
    $reflector = new ReflectionClass($class);
    
    var_dump($reflector->getFriendNames());
}
?>
--EXPECT--
array(2) {
  [0]=>
  string(1) "B"
  [1]=>
  string(1) "C"
}
array(1) {
  [0]=>
  string(1) "C"
}

