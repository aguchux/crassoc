<?php

	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', dirname(dirname(__FILE__)));

	//Initialize the Config File
	if(file_exists('config.php')){
		
		require_once('config.php');
		require_once('_config/vars.php');
		require_once('_lan/err.php');
		require_once('_lan/en.php');
		//Library
		require_once('_libs' . DS . 'golojan.sessions.php');
		require_once('_libs' . DS . 'golojan.core.php');
				
		require_once('_libs' . DS . 'golojan.smtp.php');
		require_once('_libs' . DS . 'golojan.phpmailer.php');

		require_once('_libs' . DS . 'golojan.forms.php');
		require_once('_libs' . DS . 'golojan.cpanel.php');
		
		$session = new session();
		$core = new core();
		$form = new forms();
		$index = new index();
		
		$cpanel = new xmlapi($core->cpanel_host);
		$cpanel->set_port(2083);
		$cpanel->password_auth($core->cpanel_user,$core->cpanel_pass);
		$cpanel->set_output('json');
		$cpanel->set_http_client('curl');
		$cpanel->set_debug(1);
		
		if( isset($session->data['loggedin']) ){
			$core->accid = $session->data['accid'];
			$isLoggedIn = true;
			$core->isLoggedIn = true;
			//User Info here//
				$UserInfo = $core->UserInfo($session->data['accid']);
				$core->UserInfo = $UserInfo;
				$core->username = $UserInfo->name;
				$ProfileName = "{$UserInfo->name}";
			//User Info here//
		}
	}else{
		die('config.php not found!');
	}



?>