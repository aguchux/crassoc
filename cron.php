<?php

ob_start();
define('DOT','.');
require_once(DOT ."/bootstrap.php");

if($_GET){
	$data = $form->post($_GET);
	$cron = $data->cron;
}elseif($_REQUEST){
	$data = $form->post($_REQUEST);
	$cron = $data->cron;
}
require_once(DOT ."/_crons/{$cron}.php");

ob_flush();

?>