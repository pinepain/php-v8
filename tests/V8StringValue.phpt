--TEST--
V8\StringValue
--SKIPIF--
<?php if (!extension_loaded("v8")) print "skip"; ?>
--FILE--
<?php

/** @var \Phpv8Testsuite $helper */
$helper = require '.testsuite.php';

require '.v8-helpers.php';
$v8_helper = new PhpV8Helpers($helper);

// Tests:

$isolate = new V8\Isolate();

$default = new V8\StringValue($isolate);
$helper->header('Default constructor');
$helper->dump($default);
$helper->method_export($default, 'Value');
$helper->space();


$value = new V8\StringValue($isolate, 'test string');

$helper->header('Object representation');
$helper->dump($value);
$helper->space();

$helper->assert('StringValue extends NameValue', $value instanceof \V8\NameValue);
$helper->line();

$helper->header('Accessors');
$helper->method_matches($value, 'GetIsolate', $isolate);
$helper->method_export($value, 'Value');
$helper->space();

$v8_helper->run_checks($value, 'Checkers');

$helper->header('Getters');
$helper->assert('GetIdentityHash is integer', gettype($value->GetIdentityHash()), 'integer');
$helper->method_export($value, 'Length');
$helper->method_export($value, 'Utf8Length');
$helper->method_export($value, 'IsOneByte');
$helper->method_export($value, 'ContainsOnlyOneByte');
$helper->space();

$extensions = [];
$global_template = new \V8\ObjectTemplate($isolate);
$context = new \V8\Context($isolate, $extensions, $global_template);


$helper->header('Primitive converters');
$helper->method_export($value, 'BooleanValue', [$context]);
$helper->method_export($value, 'NumberValue', [$context]);
$helper->space();


$value = new V8\StringValue($isolate, '');

$helper->header('Test empty string constructor');
$helper->method_export($value, 'Value');
$helper->method_export($value, 'BooleanValue', [$context]);
$helper->method_export($value, 'NumberValue', [$context]);
$helper->space();

$value = new V8\StringValue($isolate);

$helper->header('Test default constructor');
$helper->method_export($value, 'Value');
$helper->method_export($value, 'BooleanValue', [$context]);
$helper->method_export($value, 'NumberValue', [$context]);
$helper->space();


$helper->header('Test encodings');

foreach (['Hello, world!', 'Привет, мир!', 'こんにちは世界'] as $text ) {
  $value = new V8\StringValue($isolate, $text);

  $helper->method_export($value, 'Value');
  $helper->method_export($value, 'Length');
  $helper->method_export($value, 'Utf8Length');
  $helper->method_export($value, 'IsOneByte');
  $helper->method_export($value, 'ContainsOnlyOneByte');

  $helper->function_export('strlen', [$value->Value()]);
  $helper->space();
}


?>
--EXPECT--
Default constructor:
--------------------
object(V8\StringValue)#4 (1) {
  ["isolate":"V8\Value":private]=>
  object(V8\Isolate)#3 (5) {
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
V8\StringValue->Value(): string(0) ""


Object representation:
----------------------
object(V8\StringValue)#5 (1) {
  ["isolate":"V8\Value":private]=>
  object(V8\Isolate)#3 (5) {
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


StringValue extends NameValue: ok

Accessors:
----------
V8\StringValue::GetIsolate() matches expected value
V8\StringValue->Value(): string(11) "test string"


Checkers:
---------
V8\StringValue(V8\Value)->TypeOf(): V8\StringValue->Value(): string(6) "string"

V8\StringValue->IsOneByte(): bool(true)
V8\StringValue(V8\Value)->IsUndefined(): bool(false)
V8\StringValue(V8\Value)->IsNull(): bool(false)
V8\StringValue(V8\Value)->IsTrue(): bool(false)
V8\StringValue(V8\Value)->IsFalse(): bool(false)
V8\StringValue(V8\Value)->IsName(): bool(true)
V8\StringValue(V8\Value)->IsString(): bool(true)
V8\StringValue(V8\Value)->IsSymbol(): bool(false)
V8\StringValue(V8\Value)->IsFunction(): bool(false)
V8\StringValue(V8\Value)->IsArray(): bool(false)
V8\StringValue(V8\Value)->IsObject(): bool(false)
V8\StringValue(V8\Value)->IsBoolean(): bool(false)
V8\StringValue(V8\Value)->IsNumber(): bool(false)
V8\StringValue(V8\Value)->IsInt32(): bool(false)
V8\StringValue(V8\Value)->IsUint32(): bool(false)
V8\StringValue(V8\Value)->IsDate(): bool(false)
V8\StringValue(V8\Value)->IsArgumentsObject(): bool(false)
V8\StringValue(V8\Value)->IsBooleanObject(): bool(false)
V8\StringValue(V8\Value)->IsNumberObject(): bool(false)
V8\StringValue(V8\Value)->IsStringObject(): bool(false)
V8\StringValue(V8\Value)->IsSymbolObject(): bool(false)
V8\StringValue(V8\Value)->IsNativeError(): bool(false)
V8\StringValue(V8\Value)->IsRegExp(): bool(false)


Getters:
--------
GetIdentityHash is integer: ok
V8\StringValue->Length(): int(11)
V8\StringValue->Utf8Length(): int(11)
V8\StringValue->IsOneByte(): bool(true)
V8\StringValue->ContainsOnlyOneByte(): bool(true)


Primitive converters:
---------------------
V8\StringValue(V8\Value)->BooleanValue(): bool(true)
V8\StringValue(V8\Value)->NumberValue(): float(NAN)


Test empty string constructor:
------------------------------
V8\StringValue->Value(): string(0) ""
V8\StringValue(V8\Value)->BooleanValue(): bool(false)
V8\StringValue(V8\Value)->NumberValue(): float(0)


Test default constructor:
-------------------------
V8\StringValue->Value(): string(0) ""
V8\StringValue(V8\Value)->BooleanValue(): bool(false)
V8\StringValue(V8\Value)->NumberValue(): float(0)


Test encodings:
---------------
V8\StringValue->Value(): string(13) "Hello, world!"
V8\StringValue->Length(): int(13)
V8\StringValue->Utf8Length(): int(13)
V8\StringValue->IsOneByte(): bool(true)
V8\StringValue->ContainsOnlyOneByte(): bool(true)
strlen(): 13


V8\StringValue->Value(): string(21) "Привет, мир!"
V8\StringValue->Length(): int(12)
V8\StringValue->Utf8Length(): int(21)
V8\StringValue->IsOneByte(): bool(false)
V8\StringValue->ContainsOnlyOneByte(): bool(false)
strlen(): 21


V8\StringValue->Value(): string(21) "こんにちは世界"
V8\StringValue->Length(): int(7)
V8\StringValue->Utf8Length(): int(21)
V8\StringValue->IsOneByte(): bool(false)
V8\StringValue->ContainsOnlyOneByte(): bool(false)
strlen(): 21
