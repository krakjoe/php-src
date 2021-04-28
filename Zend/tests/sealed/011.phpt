--TEST--
Happy path
--FILE--
<?php
// ok - permits C, D
sealed interface A permits C, D {}

// ok, permitted to implements A
class C implements A {}
// ok, permitted to implements A
class D implements A {}

// ok, permitted to extend A implicitly
interface E extends A {} // ok

// ok, permitted to extend C ( non sealed ), permitted to implement E ( non sealed ) and parent interface is sealed to C
// which we extend - permits G
sealed class F extends C implements E permits G {}

// ok, permitted to extend F
class G extends F {}

// ok - permits I
sealed trait H permits I {}

// ok, permitted to use H, permitted to extend G ( non sealed ) - permits J
sealed abstract class I extends G permits J {
 use H;
}

final class J extends I {} // ok, permitted to extend I
?>
OK
--EXPECT--
OK

