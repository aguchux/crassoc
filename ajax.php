<?
ob_start();
define('DOT','.');
require_once(DOT ."/bootstrap.php");

if($_GET){
	$data = $form->post($_GET);
	$ajax = $data->ajax;
}elseif($_POST){
	$data = $form->post($_POST);
	$ajax = $data->ajax;
}elseif($_FILES){
	$data = $form->post($_FILES);
	$ajax = $data->ajax;
}

if($ajax=="checkemail"){
	$email = $data->email;
	if( strlen($email)<=4 ){
		echo 0;
	}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		echo 0;
	}else{
		$count = $core->EmailExists($email);
		if($count){
			echo 2;
		}else{
			echo 1;
		}
	}
}


if($ajax=="checkemobile"){
	$mobile = $data->mobile;
	if( strlen($mobile)<=8 ){
		echo 0;		
	}else{
		$count = $core->MobileExists($mobile);
		if($count){
			echo 2;
		}else{
			echo 1;
		}
	}
}

if($ajax=="checknickname"){
	$nickname = $data->nickname;
	if( strlen($nickname)<3 ){
		echo 0;		
	}else{
		$count = $core->NicknameExists($nickname);
		if($count){
			echo 2;
		}else{
			echo 1;
		}
	}
}

if($ajax=="getepin"){
	
	$epin = $data->epin;
	$epin = $data->epin;
	$epin = $core->Passwordify($epin);
	if($epin===$UserInfo->e_pin){
		echo 1;
	}else{
		echo 0;
	}
}

if($ajax=="mobilestatus"){
	echo intval($VerificationInfo->mobile_verified);
}

ob_flush();


?>
 

 