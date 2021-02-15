<?

ob_start();
	define('DOT','.');
	require_once(DOT ."/bootstrap.php");
	$session->expire();
	header('Location: ./do/login/');
ob_end_flush();

?>