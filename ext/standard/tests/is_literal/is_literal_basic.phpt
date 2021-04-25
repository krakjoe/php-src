--TEST--
Test is_literal() function
--FILE--
<?php

if (is_literal('x') === true) {
    echo "single char string as parameter is literal\n";
}
else {
    echo "single char string as parameter is NOT literal\n";
}

$single_char_string = '?';
if (is_literal($single_char_string) === true) {
    echo "single char string as variable is literal\n";
}
else {
    echo "single char string as variable is NOT literal\n";
}

if (is_literal('Foo') === true) {
    echo "string as parameter is literal\n";
}
else {
    echo "string as parameter is NOT literal\n";
}

$string = 'Foo 2';
if (is_literal($string) === true) {
    echo "string as variable is literal\n";
}
else {
    echo "string as variable is NOT literal\n";
}

class Foo {
    const CLASS_CONST = 'I am a class const';

    public static string $static_property = 'I am an static property';

    private string $instance_property = 'I am an instance property';

    public function getInstanceProperty() {
        return $this->instance_property;
    }
}

// class constant
if (is_literal(Foo::CLASS_CONST) === true) {
    echo "class constant is literal\n";
}
else {
    echo "class constant is NOT literal\n";
}


if (is_literal(Foo::$static_property) === true) {
    echo "class static property is literal\n";
}
else {
    echo "class static property is NOT literal\n";
}

$foo = new Foo();
if (is_literal($foo->getInstanceProperty()) === true) {
    echo "class instance property is literal\n";
}
else {
    echo "class instance property is NOT literal\n";
}

define('CONST_VALUE', 'foobar');

if (is_literal(CONST_VALUE) === true) {
    echo "constant is literal\n";
}
else {
    echo "constant is NOT literal\n";
}

$foo = 'foo';
$bar = 'foo';

$foobar = $foo . $bar;

if (is_literal($foobar) === true) {
    echo "foobar is incorrectly literal.\n";
}
else {
    echo "foobar is correctly not literal.\n";
}

echo "Done\n";

?>
--EXPECTF--
single char string as parameter is literal
single char string as variable is literal
string as parameter is literal
string as variable is literal
class constant is literal
class static property is literal
class instance property is literal
constant is literal
foobar is correctly not literal.
Done
