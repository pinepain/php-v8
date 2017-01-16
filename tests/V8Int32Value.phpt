--TEST--
V8\Int32Value
--SKIPIF--
<?php if (!extension_loaded("v8")) print "skip"; ?>
--FILE--
<?php

// Bootstraps:

$isolate = new V8\Isolate();
$value = new V8\Int32Value($isolate, 2147483647-1);

/** @var \Phpv8Testsuite $helper */
$helper = require '.testsuite.php';

require '.v8-helpers.php';
$v8_helper = new PhpV8Helpers($helper);

// Tests:

$helper->header('Object representation');
$helper->dump($value);
$helper->space();

$helper->assert('Int32Value extends IntegerValue', $value instanceof \V8\IntegerValue);
$helper->line();

$helper->header('Accessors');
$helper->method_matches($value, 'GetIsolate', $isolate);
$helper->method_export($value, 'Value');
$helper->space();


$v8_helper->run_checks($value, 'Checkers');


$extensions = [];
$global_template = new \V8\ObjectTemplate($isolate);
$context = new \V8\Context($isolate, $extensions, $global_template);


$string = $value->ToString($context);

$helper->header(get_class($value) .'::ToString() converting');
$helper->dump($string);
$helper->dump($string->Value());
$helper->space();


$helper->header('Primitive converters');
$helper->method_export($value, 'BooleanValue', [$context]);
$helper->method_export($value, 'NumberValue', [$context]);
$helper->space();


$helper->header('Test negative value in constructor');
$value = new V8\Int32Value($isolate, -123);
$helper->method_export($value, 'Value');
$helper->method_export($value, 'BooleanValue', [$context]);
$helper->method_export($value, 'NumberValue', [$context]);
$helper->space();

$v8_helper->run_checks($value, 'Checkers for negative');


$helper->header('Int32 is same as Integer - int32, so test for out-of-range (INT32_MIN-INT32_MAX)');

foreach ([PHP_INT_MAX, -PHP_INT_MAX, NAN, INF, -INF] as $val) {
  $helper->value_export($val);
  try {
    $value = new V8\Int32Value($isolate, $val);
    $helper->method_export($value, 'Value');
  } catch (Throwable $e) {
    $helper->exception_export($e);
  }
  $helper->space();
}


?>
--EXPECT--
Object representation:
----------------------
object(V8\Int32Value)#2 (1) {
  ["isolate":"V8\Value":private]=>
  object(V8\Isolate)#1 (5) {
    ["snapshot":"V8\Isolate":private]=>
    NULL
    ["time_limit":"V8\Isolate":private]=>
    float(0)
    ["time_limit_hit":"V8\Isolate":private]=>
    bool(false)
    ["memory_limit":"V8\Isolate":private]=>
    int(0)
    ["memory_limit_hit":"V8\Isolate":private]=>
    bool(false)
  }
}


Int32Value extends IntegerValue: ok

Accessors:
----------
V8\Int32Value::GetIsolate() matches expected value
V8\Int32Value->Value(): int(2147483646)


Checkers:
---------
V8\Int32Value(V8\Value)->TypeOf(): V8\StringValue->Value(): string(6) "number"

V8\Int32Value(V8\Value)->IsUndefined(): bool(false)
V8\Int32Value(V8\Value)->IsNull(): bool(false)
V8\Int32Value(V8\Value)->IsTrue(): bool(false)
V8\Int32Value(V8\Value)->IsFalse(): bool(false)
V8\Int32Value(V8\Value)->IsName(): bool(false)
V8\Int32Value(V8\Value)->IsString(): bool(false)
V8\Int32Value(V8\Value)->IsSymbol(): bool(false)
V8\Int32Value(V8\Value)->IsFunction(): bool(false)
V8\Int32Value(V8\Value)->IsArray(): bool(false)
V8\Int32Value(V8\Value)->IsObject(): bool(false)
V8\Int32Value(V8\Value)->IsBoolean(): bool(false)
V8\Int32Value(V8\Value)->IsNumber(): bool(true)
V8\Int32Value(V8\Value)->IsInt32(): bool(true)
V8\Int32Value(V8\Value)->IsUint32(): bool(true)
V8\Int32Value(V8\Value)->IsDate(): bool(false)
V8\Int32Value(V8\Value)->IsArgumentsObject(): bool(false)
V8\Int32Value(V8\Value)->IsBooleanObject(): bool(false)
V8\Int32Value(V8\Value)->IsNumberObject(): bool(false)
V8\Int32Value(V8\Value)->IsStringObject(): bool(false)
V8\Int32Value(V8\Value)->IsSymbolObject(): bool(false)
V8\Int32Value(V8\Value)->IsNativeError(): bool(false)
V8\Int32Value(V8\Value)->IsRegExp(): bool(false)


V8\Int32Value::ToString() converting:
-------------------------------------
object(V8\StringValue)#52 (1) {
  ["isolate":"V8\Value":private]=>
  object(V8\Isolate)#1 (5) {
    ["snapshot":"V8\Isolate":private]=>
    NULL
    ["time_limit":"V8\Isolate":private]=>
    float(0)
    ["time_limit_hit":"V8\Isolate":private]=>
    bool(false)
    ["memory_limit":"V8\Isolate":private]=>
    int(0)
    ["memory_limit_hit":"V8\Isolate":private]=>
    bool(false)
  }
}
string(10) "2147483646"


Primitive converters:
---------------------
V8\Int32Value(V8\Value)->BooleanValue(): bool(true)
V8\Int32Value(V8\Value)->NumberValue(): float(2147483646)


Test negative value in constructor:
-----------------------------------
V8\Int32Value->Value(): int(-123)
V8\Int32Value(V8\Value)->BooleanValue(): bool(true)
V8\Int32Value(V8\Value)->NumberValue(): float(-123)


Checkers for negative:
----------------------
V8\Int32Value(V8\Value)->TypeOf(): V8\StringValue->Value(): string(6) "number"

V8\Int32Value(V8\Value)->IsUndefined(): bool(false)
V8\Int32Value(V8\Value)->IsNull(): bool(false)
V8\Int32Value(V8\Value)->IsTrue(): bool(false)
V8\Int32Value(V8\Value)->IsFalse(): bool(false)
V8\Int32Value(V8\Value)->IsName(): bool(false)
V8\Int32Value(V8\Value)->IsString(): bool(false)
V8\Int32Value(V8\Value)->IsSymbol(): bool(false)
V8\Int32Value(V8\Value)->IsFunction(): bool(false)
V8\Int32Value(V8\Value)->IsArray(): bool(false)
V8\Int32Value(V8\Value)->IsObject(): bool(false)
V8\Int32Value(V8\Value)->IsBoolean(): bool(false)
V8\Int32Value(V8\Value)->IsNumber(): bool(true)
V8\Int32Value(V8\Value)->IsInt32(): bool(true)
V8\Int32Value(V8\Value)->IsUint32(): bool(false)
V8\Int32Value(V8\Value)->IsDate(): bool(false)
V8\Int32Value(V8\Value)->IsArgumentsObject(): bool(false)
V8\Int32Value(V8\Value)->IsBooleanObject(): bool(false)
V8\Int32Value(V8\Value)->IsNumberObject(): bool(false)
V8\Int32Value(V8\Value)->IsStringObject(): bool(false)
V8\Int32Value(V8\Value)->IsSymbolObject(): bool(false)
V8\Int32Value(V8\Value)->IsNativeError(): bool(false)
V8\Int32Value(V8\Value)->IsRegExp(): bool(false)


Int32 is same as Integer - int32, so test for out-of-range (INT32_MIN-INT32_MAX):
---------------------------------------------------------------------------------
integer: 9223372036854775807
V8\Exceptions\ValueException: Int32 value to set is out of range


integer: -9223372036854775807
V8\Exceptions\ValueException: Int32 value to set is out of range


double: NAN
TypeError: Argument 2 passed to V8\Int32Value::__construct() must be of the type integer, float given


double: INF
TypeError: Argument 2 passed to V8\Int32Value::__construct() must be of the type integer, float given


double: -INF
TypeError: Argument 2 passed to V8\Int32Value::__construct() must be of the type integer, float given
