--TEST--
Test is_literal() function
--FILE--
<?php

$zok = 'zok';
$fot = 'fot';
$pik = 'pik';

$result = literal_concat($zok, $fot, $pik);
$result_is_literal = is_literal($result);

if ($result_is_literal === true) {
    echo "Result of literal_concat is correctly a literal.\n";
}
else {
    echo "Result of literal_concat is NOT a literal.\n";
}

try {
    $non_literal_string =  $pik . " other string";
    literal_concat($zok, $fot, $non_literal_string);
    echo "literal_concat failed to throw exception for non-literal string.\n";
}
catch (LiteralStringRequiredError $e) {
    echo $e->getMessage(), "\n";
}


try {
    literal_concat($zok, $fot, new StdClass);
    echo "literal_concat failed to throw exception for incorrect type.\n";
}
catch (LiteralStringRequiredError $e) {
    echo $e->getMessage(), "\n";
}

echo "Done\n";

?>
--EXPECTF--
Result of literal_concat is correctly a literal.
Non-literal string found at position, 1
Only literal strings allowed. Found bad type at position %d
Done
