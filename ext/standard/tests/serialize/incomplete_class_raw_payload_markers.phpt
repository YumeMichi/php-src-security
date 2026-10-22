--TEST--
serialize() keeps O: for incomplete classes whose properties look like raw C: payloads
--FILE--
<?php
/* Backport of the official PHP 8.2.35 test (the enum/E: part is dropped —
 * enums do not exist before PHP 8.1). */

$raw = 'x:i:0;a:1:{i:0;s:3:"pwn";};m:a:0:{}';
$untrusted = 'a:1:{i:0;O:11:"ArrayObject":1:{s:33:"__PHP_Incomplete_Class_Serialized";s:' . strlen($raw) . ':"' . $raw . '";}}';

$stored = serialize(unserialize($untrusted, ['allowed_classes' => false]));
var_dump($stored === $untrusted);
?>
--EXPECT--
bool(true)
