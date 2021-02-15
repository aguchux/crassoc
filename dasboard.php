<?php

define('DOT','.');
require_once(DOT ."/bootstrap.php");
$ListCampaigns = $core->ListCampaigns($core->accid);
if( isset($session->data['sess_time']) ){
	$inMinutes = $core->inMinutes( $session->data['sess_time'],date('d-m-Y H:i:s') );
	if( $inMinutes <= session_timout ){
		//update//
		$session->data['sess_time'] = date('d-m-Y H:i:s');
		$session->save();
		//update//
	}else{
		$session->expire();
		$ExpiredSession = true;
	}
}else{
	$ExpiredSession = true;
}
$OnDashboard = true;
if(isset($_REQUEST['form'])){
	$HasForm = true;
	$frm = $_REQUEST['form'];
    $index->init($frm);
	if(file_exists($index->php)){
		include_once($index->php);
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <base href="<?= $core->domain ?>" />
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="template language" name="keywords">
    <meta name="robots" content="noindex, follow">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="-1" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="favicon.png" rel="shortcut icon">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link href="bower_components\select2\dist\css\select2.min.css" rel="stylesheet">
    <link href="//fast.fonts.net/cssapi/175a63a1-3f26-476a-ab32-4e21cbdb8be2.css" rel="stylesheet">
    <link href="bower_components\bootstrap-daterangepicker\daterangepicker.css" rel="stylesheet">
    <link href="bower_components\dropzone\dist\dropzone.css" rel="stylesheet">
    <link href="bower_components\datatables\media\css\jquery.dataTables.min.css" rel="stylesheet">
    <link href="bower_components\datatables\media\css\dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="bower_components\fullcalendar\dist\fullcalendar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
   	<link rel="stylesheet" type="text/css" href="bundles/countdown/jquery.countdownTimer.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="css\main.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/ajax.css">
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <?php if($ExpiredSession):?>
	<script type="text/javascript">
    	window.location.replace("<?= $core->domain ?>do/login/err/e156/");
    </script>
    <?php endif; ?>
</head>
<body>
    <div class="all-wrapper">
        <div class="layout-w">
            <div class="menu-w menu-activated-on-click ">
				<div class="element-box el-tablo">
					<div class="label">Total Campaign</div>
					<div class="value">0</div>
					<div class="trending trending-up-basic"><span>0</span><i class="os-icon os-icon-arrow-2-up"></i></div>
					<div class="trending trending-down-basic"><span>0</span><i class="os-icon os-icon-arrow-2-down"></i></div>
				</div>
                <div class="menu-and-user">
                    <ul class="main-menu">
					<?php include_once("_public/account_menu.phtml"); ?>
                    </ul>
                </div>
            </div>
            <div class="content-w">
                
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $core->domain ?>">Website</a></li>
                    <li class="breadcrumb-item"><a href="./">Dashboard</a></li>
                    <li class="breadcrumb-item"><span><?= $ProfileName ?></span></li>
                </ul>

                <div class="content-i">
                    <div class="content-box">
						<?php include_once(DOT ."/err.phtml"); ?>
						<?php if($HasForm): ?>
                            <form action="execute.php" id="form-<?= $frm ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="cmd" id="formcmd" value="<?= $frm ?>">   
							<div class="row">
                            	<div class="col-sm-9">
									<div class="element-wrapper">
										<div class="element-box">
                                            <h6 class="element-header"><?= $seo['title'] ?></h6>
											<?php include_once($index->phtml); ?>
										</div>
									</div>
                                </div>
                                <div class="col-sm-3">
									<div class="element-wrapper">
										<div class="element-box">
											
										</div>
									</div>
                                </div>
                            </div>
							</form>
                        <?php else: ?>
                        <?php include_once("_public/dashboard.phtml"); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="bower_components\moment\moment.js"></script>
    <script src="bower_components\chart.js\dist\Chart.min.js"></script>
    <script src="bower_components\select2\dist\js\select2.full.min.js"></script>
    <script src="bower_components\ckeditor\ckeditor.js"></script>
    <script src="bower_components\bootstrap-validator\dist\validator.min.js"></script>
    <script src="bower_components\bootstrap-daterangepicker\daterangepicker.js"></script>
    <script src="bower_components\dropzone\dist\dropzone.js"></script>
    <script src="bower_components\editable-table\mindmup-editabletable.js"></script>
    <script src="bower_components\datatables\media\js\jquery.dataTables.min.js"></script>
    <script src="bower_components\datatables\media\js\dataTables.bootstrap4.min.js"></script>
    <script src="bower_components\fullcalendar\dist\fullcalendar.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>    
	<script src="bundles/countdown/jquery.countdown.js"></script>   
    <script src="bundles/maskedinput/jquery.maskedinput.js"></script>
	<script src="js\main.js"></script>
    <script src="js\ajax.js"></script>

</body>



</html>