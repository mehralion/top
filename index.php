<?php

$redirect = array(
	'ruines' 	=> '/rate/ruines',
	'dt' 		=> '/rate/dt',
	'wars' 		=> '/rate/wars',
	'ppl' 		=> '/rate/ppl',
	'castles' 	=> '/rate/castles',
	'sgift' 	=> '/rate/march8',
	'ggift' 	=> '/rate/march8',
	'smaslo' 	=> '/rate/maslo',
	'gmaslo' 	=> '/rate/maslo',
);
$link = (isset($_GET['r']) && isset($redirect[$_GET['r']])) ? $redirect[$_GET['r']] : '/rate';
header('Location: '.$link, true, 302);
exit;