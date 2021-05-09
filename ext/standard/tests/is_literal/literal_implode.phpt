--TEST--
Test is_literal() function
--FILE--
<?php

$glue = ', ';
$question_mark = '?';

$pieces = [$question_mark, $question_mark, $question_mark];
$result = literal_implode($glue, $pieces);
echo "imploded string: '$result'\n";

if (is_literal($result) === true) {
    echo "imploded string is correctly literal\n";
}
else {
    echo "imploded string is NOT literal\n";
}

$pieces = array_fill(0, 5, '?');
$result = literal_implode('-', $pieces);
if (is_literal($result) === true) {
    echo "imploded string is correctly literal for array_fill\n";
}
else {
    echo "imploded string is NOT literal for array_fill\n";
}
if ($result !== '?-?-?-?-?') {
    echo "Imploded string is not '?-?-?-?-?' but instead $result\n";
}

$non_literal_string = 'Foo' . rand(1000, 2000);

if (is_literal($non_literal_string) === false) {
    echo "non_literal_string is correctly not literal\n";
}
else {
    echo "non_literal_string is falsely literal, aborting tests.\n";
    exit(-1);
}

try {
    $result = literal_implode($non_literal_string, $pieces);
    echo "literal_implode failed to throw exception for non-literal glue.\n";
}
catch(LiteralStringRequiredError $e) {
    echo $e->getMessage(), "\n";
}


$pieces = [$question_mark, $non_literal_string, $question_mark];

try {
    $result = literal_implode($glue, $pieces);
    echo "literal_implode failed to throw exception for non-literal piece.\n";
}
catch(LiteralStringRequiredError $e) {
    echo $e->getMessage(), "\n";
}


echo "Done\n";

?>
--EXPECTF--
imploded string: '?, ?, ?'
imploded string is correctly literal
imploded string is correctly literal for array_fill
non_literal_string is correctly not literal
glue must be literal string
Non-literal string found at position %d
Done
