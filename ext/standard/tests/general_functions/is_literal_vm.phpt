--TEST--
test concat + is_literal function
--FILE--
<?php
$hello = "hello";
$world = "world";

var_dump(
    is_literal("Hello" . "World"),
    is_literal($hello . "" . $world),
    is_literal($hello . "world"),
    is_literal("hello" . $world),
    is_literal("hello" . " to " . " the " . $world),
    is_literal("hello" . sprintf("world")));
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(false)
