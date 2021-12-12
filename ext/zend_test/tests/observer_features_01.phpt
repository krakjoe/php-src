--TEST--
Observer: ZEND_OBSERVE_STACK_DEPTH
--EXTENSIONS--
zend_test
--INI--
zend_test.observer.enabled=1
zend_test.observer.observe_all=1
zend_test.observer.features.stack_depth=On
--FILE--
<?php
function foo() {
	echo __FUNCTION__ . PHP_EOL;
}
function bar() {
	echo __FUNCTION__ . PHP_EOL;
	foo();
}
function baz() {
	echo __FUNCTION__ . PHP_EOL;
	bar();
}
baz();
echo "DONE\n";
?>
--EXPECTF--
<!-- init '%s%eobserver_features_01.php' -->
<file '%s%eobserver_features_01.php'>
  <depth 1>
  <!-- init baz() -->
  <baz>
    <depth 2>
baz
    <!-- init bar() -->
    <bar>
      <depth 3>
bar
      <!-- init foo() -->
      <foo>
        <depth 4>
foo
      </foo>
    </bar>
  </baz>
DONE
</file '%s%eobserver_features_01.php'>
