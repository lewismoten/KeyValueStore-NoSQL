<?php

include 'core.php';

validateRequest();
$pair = getInput();
$db = openDatabase();

$query = sprintf("
	
insert into `keyvaluestore` (
	`key`,
	`value`
) values (
	'%s', 
	'%s'
)
on duplicate key update
	`key` = values(`key`),
	`value` = values(`value`);

	", 
	$db->real_escape_string($pair->key),
	$db->real_escape_string($pair->value));

$reader = $db->query($query);

if($reader === false) {

	showError($db->error);
	exit;

}

showPair($pair->key, $pair->value);

$db->close();

?>