<?php

if( isset($session->data['sess_time']) ){
	$inMinutes = $core->inMinutes( $session->data['sess_time'],date('d-m-Y H:i:s') );
	if( $inMinutes <= session_timout ){
		//update//
		$session->data['sess_time'] = date('d-m-Y H:i:s');
		$session->save();
		//update//
	}else{
		$session->expire();
		$core->redirect_to("./me.php");
	}
}



