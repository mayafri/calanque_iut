<?php
header('Content-Type: text/plain');

function testtime($fun, ...$params) {
  $mtime = microtime();
  $mtime = explode(" ",$mtime);
  $mtime = $mtime[1] + $mtime[0];
  $starttime = $mtime;
  $fun(...$params);
  $mtime = microtime();
  $mtime = explode(" ",$mtime);
  $mtime = $mtime[1] + $mtime[0];
  $endtime = $mtime;
  return $endtime - $starttime;
}

function test($name, $fun, ...$params) {
  echo str_pad($name, 20) . ": " . sprintf('%.015lf', testtime($fun, ...$params)) . " s\n";
}

echo "----\nAjout à la fin d'un array\n";

test("array_push", function() {
  $array = array();
  for ($x = 1; $x <= 100000; $x++) {
    array_push($array, $x);
  }
});

test("array[]", function() {
  $array = array();
  for ($x = 1; $x <= 100000; $x++) {
    $array[] = $x;
  }
});

echo "----\nAjout d'un élément qui doit être unique dans l'array, et trié (comportement d'un Set/ensemble)\n";

$dataset = [];
for ($iter = 0; $iter < 128; ++$iter) {
  for ($grp = '1'; $grp <= '9'; ++$grp) {
    for ($sem = '1'; $sem <= '9'; ++$sem) {
      $dataset[] = "G" . $grp . "S" . $sem;
    }
  }
}

$target = [];
for ($grp = '1'; $grp <= '9'; ++$grp) {
  for ($sem = '1'; $sem <= '9'; ++$sem) {
    $target[] = "G" . $grp . "S" . $sem;
  }
}

test("array_unique+sort", function() {
  global $dataset;
  global $target;
  $array_groups = [];
  foreach ($dataset as $i) {
    $array_groups[] = $i;
  }
  $array_groups = array_unique($array_groups);
  sort($array_groups);
  echo ($array_groups === $target) ? "" : "ARRAYS NOT EQUAL!";
});

test("!in_array+sort", function() {
  global $dataset;
  global $target;
  $array_groups = [];
  foreach ($dataset as $i) {
    if (!in_array($i, $array_groups, true)) {
      $array_groups[] = $i;
    }
  }
  sort($array_groups);
  echo ($array_groups === $target) ? "" : "ARRAYS NOT EQUAL!";
});

test("assoc+iter_kv", function() {
  global $dataset;
  global $target;
  $map_groups = [];
  foreach ($dataset as $i) {
    $map_groups[$i] = null;
  }
  $array_groups = [];
  foreach ($map_groups as $key => $val) {
    $array_groups[] = $key;
  }
  echo ($array_groups === $target) ? "" : "ARRAYS NOT EQUAL!";
});

test("assoc+array_keys", function() {
  global $dataset;
  global $target;
  $map_groups = [];
  foreach ($dataset as $i) {
    $map_groups[$i] = null;
  }
  $array_groups = array_keys($map_groups);
  echo ($array_groups === $target) ? "" : "ARRAYS NOT EQUAL!";
});
?>
