--TEST--
Observer: ZEND_OBSERVE_STACK_DEPTH basic fibers
--EXTENSIONS--
zend_test
--INI--
zend_test.observer.enabled=1
zend_test.observer.observe_all=1
zend_test.observer.features.stack_depth=On
--FILE--
<?php
function fiber_one_function($two) {
	echo "Fiber 1:";
	foreach(array_reverse(debug_backtrace()) as $frame) {
		if (isset($frame["class"])) {
		    echo " -> {$frame["class"]}::{$frame["function"]}";
		} else {
			echo " -> {$frame["function"]}";
		}
	}
	echo PHP_EOL;
	$two->start();
}
function fiber_two_function() {
	echo "Fiber 2:";
	foreach(array_reverse(debug_backtrace()) as $frame) {
		if (isset($frame["class"])) {
		    echo " -> {$frame["class"]}::{$frame["function"]}";
		} else {
			echo " -> {$frame["function"]}";
		}
	}
	echo PHP_EOL;
}
$two = new Fiber('fiber_two_function');
$one = new Fiber('fiber_one_function');
$one->start($two);
(function(){
	echo "Fiber End\n";
})();
echo "DONE\n";
?>
--EXPECTF--
<!-- init '%s%eobserver_features_02.php' -->
<file '%s%eobserver_features_02.php'>
  <depth 1>
  <!-- init fiber_one_function() -->
  <fiber_one_function>
      <depth 3>
Fiber 1: -> Fiber::start -> fiber_one_function
    <!-- init fiber_two_function() -->
    <fiber_two_function>
          <depth 5>
Fiber 2: -> Fiber::start -> fiber_one_function -> Fiber::start -> fiber_two_function
    </fiber_two_function>
  </fiber_one_function>
  <!-- init {closure}() -->
  <{closure}>
    <depth 2>
Fiber End
  </{closure}>
DONE
</file '%s%eobserver_features_02.php'>
