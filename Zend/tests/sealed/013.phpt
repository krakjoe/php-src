--TEST--
Using sealed traits
--FILE--
<?php
sealed trait A permits C, D {
  public function speak(): void
  {
    echo '*bark* ';
  }
}

class C { use A; } // OK

(new C)->speak();

class D { use A; } // OK

(new D)->speak();

class G extends C {} // OK

(new G)->speak();

class H extends D {} // OK

(new H)->speak();

class K { use A; } // K.O
?>
--EXPECT--
*bark* *bark* *bark* *bark*
Fatal error: Class K cannot use sealed trait A in %s/013.php on line %d
