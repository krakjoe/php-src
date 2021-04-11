--TEST--
test ropes + is_literal function
--FILE--
<?php
$hello = "hello";
$world = "world";
$sprintfed = sprintf("hello %s", "world");

var_dump(
    is_literal("{$hello} {$world}"),
    is_literal("{$sprintfed} {$world}"));
?>
--EXPECT--
bool(true)
bool(false)
