--TEST--
Observer: ZEND_OBSERVE_STACK_DEPTH switching fibers
--EXTENSIONS--
zend_test
--INI--
zend_test.observer.enabled=1
zend_test.observer.observe_all=1
zend_test.observer.features.stack_depth=On
--FILE--
<?php
function resumed() {
	echo __FUNCTION__ . PHP_EOL;
}
function suspended() {
	echo __FUNCTION__ . PHP_EOL;
}

function fiber_function() {
	echo "Fiber 1:";
	foreach(array_reverse(debug_backtrace()) as $frame) {
		if (isset($frame["class"])) {
		    echo " -> {$frame["class"]}::{$frame["function"]}";
		} else {
			echo " -> {$frame["function"]}";
		}
	}
	echo PHP_EOL;
	Fiber::suspend();
	resumed();
}

$one = new Fiber('fiber_function');
$one->start();
suspended();
$one->resume();
echo "DONE\n";
?>
--EXPECTF--
<!-- init '%s%eobserver_features_03.php' -->
<file '%s%eobserver_features_03.php'>
  <depth 1>
  <!-- init fiber_function() -->
  <fiber_function>
      <depth 3>
Fiber 1: -> Fiber::start -> fiber_function
    <!-- init suspended() -->
    <suspended>
    <depth 2>
suspended
    </suspended>
    <!-- init resumed() -->
    <resumed>
        <depth 4>
resumed
    </resumed>
  </fiber_function>
DONE
</file '%s%eobserver_features_03.php'>
