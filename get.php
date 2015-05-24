<?php
include 'core.php';

validateRequest();
$pair = getInput();
$db = openDatabase();

$query = sprintf("
	
select
	`key`,
	`value`
from
	`keyvaluestore`
where
	`key` = '%s'
limit 1
", 
	$db->real_escape_string($pair->key));

$reader = $db->query($query);

if($reader === false) {

	showError('error querying against database');
	exit;

}

$row = $reader->fetch_assoc();

if($row === null) {
	showError('key does not exist');
	exit;
}

showPair(
	$row["key"], 
	$row["value"]
	);

$reader->free();

$db->close();


?>