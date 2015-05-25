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

delete `keyvaluestore`
from 
  `keyvaluestore`
left join
  (
    select `key`
    from `keyvaluestore`
    order by `modified` desc
    limit 500
  ) as `keep`
on `keyvaluestore`.`key`= `keep`.`key`
where
  `keep`.`key` is null;

OPTIMIZE TABLE  `keyvaluestore`;
	", 
	$db->real_escape_string($pair->key),
	$db->real_escape_string($pair->value));

$reader = $db->multi_query($query);

if($reader === false) {

	showError($db->error);
	exit;

}

showPair($pair->key, $pair->value);

$db->close();

?>