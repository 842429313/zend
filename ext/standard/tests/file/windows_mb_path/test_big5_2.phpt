--TEST--
Test fopen() for write big5 to UTF-8 path
--SKIPIF--
<?php
include dirname(__FILE__) . DIRECTORY_SEPARATOR . "util.inc";

skip_if_not_win();
if (getenv("SKIP_SLOW_TESTS")) die("skip slow test");
skip_if_no_required_exts();
skip_if_wrong_cp(950, "ansi");

?>
--INI--
default_charset=cp950
--FILE--
<?php
/*
#vim: set fileencoding=big5
#vim: set encoding=big5
*/

include dirname(__FILE__) . DIRECTORY_SEPARATOR . "util.inc";

$item = "測試多字節路徑"; // BIG5 string
$prefix = create_data("file_big5", $item . "25", 950);
$fn = $prefix . DIRECTORY_SEPARATOR . "{$item}25";

$f = fopen($fn, 'w');
if ($f) {
	var_dump($f, fwrite($f, "writing to an mb filename"));
	var_dump(fclose($f));
} else {
	echo "open utf8 failed\n";
}

var_dump(file_get_contents($fn));

get_basename_with_cp($fn, 950);

var_dump(unlink($fn));

remove_data("file_big5");

?>
===DONE===
--EXPECTF--
resource(%d) of type (stream)
int(25)
bool(true)
string(25) "writing to an mb filename"
Active code page: 950
getting basename of %s測試多字節路徑25
string(%d) "測試多字節路徑25"
bool(true)
string(%d) "%s皜祈岫憭?摮?蝭?頝臬??25"
Active code page: %d
bool(true)
===DONE===
