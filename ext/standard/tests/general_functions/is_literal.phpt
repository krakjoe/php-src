--TEST--
test is_literal function
--FILE--
<?php
$literal = "literal";
$copy    = $literal;
var_dump(is_literal("literal"),
         is_literal($literal),
         is_literal($copy),
         is_literal(sprintf("literal %s", "string")),
         is_literal(null),
         is_literal(42));
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(false)
bool(false)
bool(false)
