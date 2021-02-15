<? 

header('Content-Type: text/plain; charset=utf-8');
ob_start();
define('DOT','.');

require_once(DOT ."/bootstrap.php");
if($_POST):
	
	
	$data = $form->post($_POST);
	$data_file = $form->post($_FILES);
	$cmd = $data->cmd;
	$core_accid = $core->accid;
	if($core->use_token_security){
		$token_sent = $data->token;
		$token_set = $session->data['token'];
		if($token_sent!==$token_set){
			$core->redirect_to($core->domain);	
			exit();
		}
	}

		
	if($cmd=="login"){
		
		$email = $data->email;
		$password = $data->password;
		
		$login = $core->DoxLogin($email,$password);
		$accid = $login['accid'];
		if($accid){
			$core->isLoggedIn = true;
			$session->data['loggedin'] = true;
			$session->data['accid'] = $accid;
			$session->data['sess_time'] = date('d-m-Y H:i:s');
			$session->save();	
			$core->redirect_to($core->domain);	
			exit();
		}else{
			$core->redirect_to($core->domain . "do/login/err/e100/");	
			exit();
		}

	
	}elseif($cmd=="create-subscriber"){
		
		$accid = $core->accid;
		$groupname = $data->groupname;
		$li = $core->CreateGroup($accid,$groupname);
		if($li){
			$core->redirect_to($core->domain . "dashboard/groups/");	
			exit();
		}
		$core->redirect_to($core->domain . "dashboard/create-subscriber/");	
		exit();
	
	
	}elseif($cmd=="upload-list"){
				
		$accid = $core->accid;
		$gid = $data->gid;
		
		$p_upnm	=  $_FILES["emailfile"]["tmp_name"];
		
		$wholeTextFile = explode("\r\n", file_get_contents($p_upnm));
		$wholeTextFile = array_unique($wholeTextFile);	
		$wholeTextFile = array_values($wholeTextFile);
		$emailcount = count($wholeTextFile);
		$wholeTextFile = json_encode($wholeTextFile);	
		
		$done = $core->AddToList($gid,$wholeTextFile,$emailcount);
		
		$core->redirect_to($core->domain . "dashboard/groups/");
	
	
	}elseif($cmd=="compose"){
		
		$accid = $core->accid;
		$title = $data->title;
		
		$fromname = $data->fromname;
		$fromemail = $data->fromemail;
		$replyname = $data->replyname;
		$replyemail = $data->replyemail;
		
		$contents = $data->contents;
		
		$done = $core->ComposeMail($accid,$title,$fromname,$fromemail,$replyname,$replyemail,$contents);		
		if($done){
			$core->redirect_to($core->domain . "dashboard/mails/");	
			exit();
		}else{
			$core->redirect_to($core->domain . "dashboard/compose/");	
			exit();
		}
	
	
	
	
	
	
	}elseif($cmd=="create-campaign"){
	
		$accid = $core->accid;
		
		$campaign = $data->campaign;
		$mid = $data->demail;
		$gid = $data->group;
		
		$epm = 1;
		$treaded = 1;
		$trottled = 1;
		if(isset($data->epm)){
			$epm = $data->epm;
		}
		if(isset($data->trottled)){
			$trottled = $data->trottled;
		}
		if(isset($data->treaded)){
			$treaded = $data->treaded;
		}
		
		$cpn = $core->SetupCampaign($accid,$campaign,$mid,$gid,$epm,$trottled,$treaded);
		if($cpn){
			$core->redirect_to($core->domain . "dashboard/campaigns/");	
			exit();
		}else{
			$core->redirect_to($core->domain . "dashboard/create-campaign/");	
			exit();
		}
	
	
	
	}elseif($cmd=="manage-country"){
		
		$countryid = $data->countryid;
		$ThisCountry = $core->GetCountry($countryid);
				
		$country = $core->UpdateCountry($countryid,"currency",$data->currency);
		$core->UpdateCountry($countryid,"currencycode",$data->currencycode);
		$core->UpdateCountry($countryid,"min_deposit",$data->min_deposit);
		$core->UpdateCountry($countryid,"max_deposit",$data->max_deposit);
		$core->UpdateCountry($countryid,"enabled",$data->enabled);	
			
		$core->LogTrack($core_accid,"Updated Country settings for {$ThisCountry->nicename}");
		$core->redirect_to($core->domain . "dashboard/manage-country/{$countryid}/");
			
	}elseif($cmd=="adminaccess"){
		
		$adminaccid = $core->accid;
		$accid = $data->accid;
		$IsAdmin = $core->UserHasRole($adminaccid,'admin');
		if($IsAdmin){
			$USR = $core->UserInfo($accid);
			$core->isLoggedIn = true;
			$session->data['loggedin'] = false;
			$session->data['accid'] = $USR->accid;
			$session->data['sess_time'] = date('d-m-Y H:i:s');
			$session->save();	
			$core->LogTrack($core_accid,"logged in as {$core->TraceAccid($accid)}");
			$core->redirect_to($core->domain . "dashboard/");	
			exit();
		}else{
			$core->redirect_to($core->domain . "dashboard/");	
			exit();
		}

	}elseif($cmd=="verify-mobile"){

		$accid = $core->accid;
		$phonecode = $data->phonecode;
		$mobile = $data->mobile;
		
		$MobileHashExists = $core->MobileHashExists($accid,$mobile);
		if($MobileHashExists){
			$core->redirect_to($core->domain . "dashboard/verify-mobile/alter-mobile/err/e201/");	
			exit();
		}				
		
		if($mobile!==$UserInfo->mobile){
			$core->SetVerify($accid,"mobile_verified",0);
			$mobile_verification_key = strtolower("ACD{$accid}" . $this->GenPassword(3));	
			$core->UpdateUser($accid,"mobile_verification_key",$mobile_verification_key);	
		}
		
		$core->UpdateUser($accid,"mobile",$mobile);	
		$core->UpdateUser($accid,"phonecode","+" . $phonecode);	
				
		$core->redirect_to($core->domain . "dashboard/verify-mobile/err/m401/");	
		exit();

	}elseif($cmd=="edit-profile"){

				

		$accid = $core->accid;		

		$nickname = $data->nickname;

		$core->UpdateUser($accid,"nickname",$nickname);	

		

		$phonecode = $data->phonecode;

		$core->UpdateUser($accid,"phonecode","+" . $phonecode);	

		

		$mobile = $data->mobile;

		$MobileHashExists = $core->MobileHashExists($accid,$mobile);

		if($MobileHashExists){

			$core->redirect_to($core->domain . "dashboard/edit-profile/err/e201/");	

			exit();

		}

						

		if($mobile!==$UserInfo->mobile){

			$core->UnTrusteer($accid,25);

			$core->SetVerify($accid,"mobile_verified",0);	

		}

		$core->UpdateUser($accid,"mobile",$mobile);	

		

		

		$email_notix = 0;		

		if(isset($data->email_notix)){

			$email_notix = $data->email_notix;

		}

		$core->UpdateUser($accid,"email_notix",$email_notix);

		

		$sms_notix = 0;		

		if(isset($data->email_notix)){

			$sms_notix = $data->sms_notix;

		}

		$core->UpdateUser($accid,"sms_notix",$sms_notix);

		

		$pUser = $core->UserInfo($accid);

		$Profile_Name = "{$pUser->nickname}";

		$subject = "Profile Updated";

		$html = sprintf($_lan['MAIL']['PROFILE_UPDATE'],$Profile_Name);

		$core->NoReply($pUser->email,$Profile_Name,$subject,$html);

		

		$core->LogTrack($core_accid,"updated profile");

		$core->redirect_to($core->domain . "dashboard/edit-profile/err/m401/");	

		exit();


	}elseif($cmd=="reset"){
		
		$email = $data->email;
		$EmailExists = $core->EmailExists($email);
		if(!$EmailExists){
			$core->redirect_to($core->domain . "do/reset/err/e300/");	
			exit();
		}
		$password = $core->GenPassword(6);
		$finalpassword = $core->Passwordify($password);
		$ResetUser = $core->UserInfoByEmail($email);
		$core->UpdateUser($ResetUser->accid,"password",$finalpassword);	
		$core->UpdateUser($ResetUser->accid,"password_reset",1);
		$pUser = $core->UserInfo($ResetUser->accid);
		$Profile_Name = "{$pUser->nickname}";
		$subject = "New Password Reset";
		$html = sprintf($_lan['MAIL']['ACCOUNT_RESET'],$Profile_Name,$password);
		$core->NoReply($pUser->email,$Profile_Name,$subject,$html);
		$core->LogTrack($core_accid,"reset account password");
		$core->redirect_to($core->domain . "do/reset-done/");	
		exit();
		
	}elseif($cmd=="matchdonor"){
		
		$donid = $data->donid;
		$ThisDonor = $core->GetDonor($donid);
		$DonorUser = $core->UserInfo($ThisDonor->accid);
		$DonorAmount = $ThisDonor->amount;
		
		$transid = $data->transid;
		$GetOrder = $core->GetOrder($transid);
		
		$CanGH  = $core->UserHasRole($GetOrder->accid,$core->cron_enabled_group);
		if($CanGH){
			
			$transid_gh = $transid;
			$accid_gh = $GetOrder->accid;
			
			//Calculate PH Payment information//
			$GHtotal = $GetOrder->payout - $core->GHcompleted($GetOrder->transid);
			
			if($GHtotal==$DonorAmount){
				
				$AmounToPay = $GHtotal;
				$do = $core->CreateDonorMatch($donid,$transid,$transid_gh,$DonorUser->accid,$GetOrder->accid,$AmounToPay,100,100);
				
				$ghUser = $core->UserInfo($ghOrder->accid);
				$ghProfile_Name = "{$ghUser->nickname}";
				$ghSubject = "New Matched Payment [GH#{$GetOrder->transid}] - {$AmounToPay} NGN";
				$ghHtml = sprintf($_lan['MAIL']['NEW_GH_MATCH'],$ghProfile_Name);
				$core->NoReply($phUser->email,$ghProfile_Name,$ghSubject,$ghHtml);
				
				$core->redirect_to($core->domain . "dashboard/alldonors/err/m401/");	
				exit();
				
			}
			$core->redirect_to($core->domain . "dashboard/matchdonor/{$donid}/");	
			exit();
				
				
		}
		$core->redirect_to($core->domain . "dashboard/matchdonor/{$donid}/");	
		exit();
				
	
	
	
	}elseif($cmd=="new-donor"){

		$accid = $data->accid;
		$amount = $data->amount;
		
		$nickname = $data->nickname;
		$email = $data->email;
		
		$phonecode = "+" . $data->phonecode;
		$mobile = $data->mobile;
		$lastmobile = ltrim($mobile,"0");
		$lastmobile = $phonecode . $lastmobile;
		
		$bulkmatch = 0;
		if( isset($data->bulkmatch) ){
			$bulkmatch = $data->bulkmatch;
		}


		$can_gh = 0;
		if( isset($data->can_gh) ){
			$can_gh = $data->can_gh;
		}
		$trash_ph = 0;
		if( isset($data->trash_ph) ){
			$trash_ph = $data->trash_ph;
		}
		$silent_email = 0;
		if( isset($data->silent_email) ){
			$silent_email = $data->silent_email;
		}

		if($core->DonorExists($nickname,$email)){
			$core->redirect_to($core->domain . "dashboard/new-donor/err/e290/");	
			exit();
		}
		
		$donor = $core->NewDonor($nickname,$email,$can_gh,$trash_ph,$silent_email,$accid,$amount,$bulkmatch);
		if($donor){
			$core->redirect_to($core->domain . "dashboard/alldonors/err/m401/");	
			exit();
		}
		
		$core->redirect_to($core->domain . "dashboard/new-donor/err/e402/");	
		exit();
		
	
	}elseif($cmd=="register"){

		

		$nickname = $data->nickname;

		$email = $data->email;

		$phonecode = "+" . $data->phonecode;

		

		$mobile = $data->mobile;

		

		$lastmobile = ltrim($mobile,"0");

		$lastmobile = $phonecode . $lastmobile;

		

		

		if($core->NicknameExists($nickname)){

			$core->redirect_to($core->domain . "do/register/err/e203/");	

			exit();

		}

		

		if($core->EmailExists($email)){

			$core->redirect_to($core->domain . "do/register/err/e200/");	

			exit();

		}

		

		if($core->MobileExists($mobile)){
			$core->redirect_to($core->domain . "do/register/err/e201/");	
			exit();
		}

		$password = $core->GenPassword(6);
		$finalpassword = $core->Passwordify($password);
		

		$RefId = NULL;

		if(isset($data->refemail)){

			$refemail = $data->refemail;

			$RefUser = $core->UserInfoByEmail($refemail);

			if($RefUser->accid){

				$RefId = $RefUser->accid;

			}

		}

		

		$created = $core->CreateQuickUser( $nickname,$email,$phonecode,$mobile,$finalpassword,$RefId );

				

		if($created){

			

			$pUser = $core->UserInfo($created);

			$Profile_Name = "{$pUser->nickname}";

			$subject = "Welcome {$Profile_Name}, Your Password";

			$html = sprintf($_lan['MAIL']['WELCOME_NEW'],$Profile_Name,$email,$password);

			$core->NoReply($pUser->email,$Profile_Name,$subject,$html);

			

			$session->data['accid'] = $created;

			$session->save();		

			

			$core->redirect_to($core->domain . "do/reg-done/");	

			exit();

			

		}else{

			$core->redirect_to($core->domain . "do/register/err/e202/");	

			exit();

		}



	}elseif($cmd=="setpin"){

		

		if(!isset($session->data['accid'])){

			$core->redirect_to($core->domain . "do/login/");	

			exit();

		}

				

		$accid = $session->data['accid'];

		$pUser = $core->UserInfo($accid);

		

		$epin = $data->epin;

		$repin = $data->repin;

		if(strlen($epin) < 4 ){

			$core->redirect_to($core->domain . "do/setpin/err/e500/");	

			exit();

		}

		

		if($epin!=$repin){

			$core->redirect_to($core->domain . "do/setpin/err/e501/");	

			exit();

		}

		

		$epin = $core->Passwordify($epin);

		$core->UpdateUser($accid,"e_pin",$epin);

		if(!$pUser->e_pin_set){

			$core->UpdateUser($accid,"e_pin_set",1);

			$core->Trusteer($accid,25);	

		}



		$Profile_Name = "{$pUser->nickname}";

		$subject = "ePIN Created";

		$html = sprintf($_lan['MAIL']['E_PIN_CREATE_DONE'],$Profile_Name);

		$core->NoReply($pUser->email,$Profile_Name,$subject,$html);



		$session->data['loggedin'] = true;

		$session->data['accid'] = $accid;

		$session->data['sess_time'] = date('d-m-Y H:i:s');

		$session->save();

				

		$core->LogTrack($core_accid,"created ePIN");

		$core->redirect_to($core->domain . "dashboard/err/m502/");	

		exit();





	}elseif($cmd=="e-pin"){

		

		$accid = $core->accid;

		$pUser = $core->UserInfo($accid);

		

		$epin = $data->epin;

		$repin = $data->repin;

		if(strlen($epin) < 4 ){

			$core->redirect_to($core->domain . "dashboard/e-pin/err/e500/");	

			exit();

		}

		

		if($epin!=$repin){

			$core->redirect_to($core->domain . "dashboard/e-pin/err/e501/");	

			exit();

		}

		

		$epin = $core->Passwordify($epin);

		$core->UpdateUser($accid,"e_pin",$epin);

		if(!$pUser->e_pin_set){

			$core->UpdateUser($accid,"e_pin_set",1);

			$core->Trusteer($accid,25);	

		}

		

		$Profile_Name = "{$pUser->nickname}";

		$subject = "ePIN Changed";

		$html = sprintf($_lan['MAIL']['E_PIN_RESET_DONE'],$Profile_Name);

		$core->NoReply($pUser->email,$Profile_Name,$subject,$html);

					

		

		$core->LogTrack($core_accid,"changed ePIN");

		$core->redirect_to($core->domain . "dashboard/e-pin/err/m401/");	

		exit();







	}elseif($cmd=="bank-details"){

		

		$accid = $core->accid;

		

		$BankerLock = $UserBankInfo->locked;

		if($BankerLock){

			$core->redirect_to($core->domain . "dashboard/bank-details/err/e702/");	

			exit();

		}

		

		$bhashkey = $core->Passwordify( $data->banker . $data->account_number );

		$BHashExists = $core->BHashExists($accid,$bhashkey);

		if($BHashExists){

			$core->redirect_to($core->domain . "dashboard/bank-details/err/e701/");	

			exit();

		}

		

		$account_number = $data->account_number;

		$IsNumeric = ctype_digit($account_number);

		if(!$IsNumeric){

			$core->redirect_to($core->domain . "dashboard/bank-details/err/e703/");	

			exit();

		}

				

		$core->UpdateBanker($accid,"banker",$data->banker);

		$core->UpdateBanker($accid,"accountnumber",$data->account_number);

		

		$core->UpdateBanker($accid,"bhash",$bhashkey);

				

		$core->UpdateBanker($accid,"accountname",$data->account_name);

		$core->UpdateBanker($accid,"accounttype",$data->accounttype);		

		$core->UpdateBanker($accid,"status","created");

		

		if(!$UserBankInfo->bank_verified){

			$core->SetVerify($accid,"bank_verified",1);

			$core->Trusteer($accid, 25);

		}



		$ThisBank = $core->GetBank($data->banker);

		$pUser = $core->UserInfo($accid);

		$Profile_Name = "{$pUser->nickname}";

		$subject = "Bank Account Updated";

		$html = sprintf($_lan['MAIL']['BANK_UPDATED'],$Profile_Name,$ThisBank->name,$data->account_name,$data->account_number,$data->accounttype);

		$core->NoReply($pUser->email,$Profile_Name,$subject,$html);



		$core->LogTrack($core_accid,"updated accounts/bank");

		$core->redirect_to($core->domain . "dashboard/bank-details/err/m401/");	

		exit();

	

	

	}elseif($cmd=="alter-password"){

		

		$accid = $core->accid;

		

		$oldpass = $data->oldpass;

		if($UserInfo->password!==$core->Passwordify($oldpass)){

			$core->redirect_to($core->domain . "dashboard/alter-password/err/e600/");	

			exit();

		}

		

		$newpass = $data->newpass;

		$repass = $data->repass;

		if(md5($newpass)!==md5($repass)){

			$core->redirect_to($core->domain . "dashboard/alter-password/err/e601/");	

			exit();

		}

		

		$core->UpdateUser($accid,"password",$core->Passwordify($newpass));	

		

		$pUser = $core->UserInfo($accid);

		$Profile_Name = "{$pUser->nickname}";

		$subject = "Password Changed";

		$html = sprintf($_lan['MAIL']['ACCOUNT_RESET_DONE'],$Profile_Name);

		$core->NoReply($pUser->email,$Profile_Name,$subject,$html);

					

		

		$core->LogTrack($core_accid,"updated password");

		$core->redirect_to($core->domain . "dashboard/alter-password/err/m401/");	

		exit();

		

		

	}elseif($cmd=="passwordify"){



		$accid = $session->data['accid'];

		

		$newpass = $data->password1;

		$repass = $data->password2;

		if(md5($newpass)!==md5($repass)){

			$core->redirect_to($core->domain . "do/passwordify/err/e601/");	

			exit();

		}

		$core->UpdateUser($accid,"password",$core->Passwordify($newpass));	

		$core->UpdateUser($accid,"password_reset",0);	

		

		$core->Trusteer($accid, 25);	



		

		$session->data['loggedin'] = true;

		$session->data['accid'] = $accid;

		$session->data['sess_time'] = date('d-m-Y H:i:s');

		$session->save();

		

		$pUser = $core->UserInfo($accid);

		$Profile_Name = "{$pUser->nickname}";

		$subject = "Password Changed";

		$html = sprintf($_lan['MAIL']['ACCOUNT_RESET_DONE'],$Profile_Name);

		$core->NoReply($pUser->email,$Profile_Name,$subject,$html);

		

			

		if($login->e_pin_set==0){

			$core->redirect_to($core->domain . "do/setpin/");	

			exit();

		}

		

		$core->LogTrack($core_accid,"reset password");

		$core->redirect_to($core->domain . "dashboard/err/m401/");	

		exit();

		

		

	}elseif($cmd=="site-home"){

		foreach($data as $dkey=>$dval){

			$core->SetOption($dkey,$dval);

		}

		

		$core->LogTrack($core_accid,"updated site home page settings");

		$core->redirect_to($core->domain . "dashboard/site-home/err/m401/");	

		exit();

	

	}elseif($cmd=="site-settings"){

		

		$core->SetSiteInfo(1,"title",$data->title);

		$core->SetSiteInfo(1,"domain",$data->domain);

		$core->SetSiteInfo(1,"admin_message_body",$data->admin_message_body);
		
		
		$core->SetSiteInfo(1,"testrole",$data->testrole);
		
		$core->SetSiteInfo(1,"ph_batch_qty",$data->ph_batch_qty);

		$core->SetSiteInfo(1,"gh_batch_qty",$data->gh_batch_qty);

		$core->SetSiteInfo(1,"ph_insure_percentage",$data->ph_insure_percentage);

		$core->SetSiteInfo(1,"ph_insure_start_time",$data->ph_insure_start_time);

		$core->SetSiteInfo(1,"payout",$data->payout);

    	$core->SetSiteInfo(1,"pay_period",$data->pay_period);



    	$core->SetSiteInfo(1,"trusteer_default_value",$data->trusteer_default_value);

    	$core->SetSiteInfo(1,"default_trustpoint",$data->default_trustpoint);

    	$core->SetSiteInfo(1,"start_match_range",$data->start_match_range);

		

		if(isset($data->bypass_match_range)){

			$core->SetSiteInfo(1,"bypass_match_range",1);

		}else{

			$core->SetSiteInfo(1,"bypass_match_range",0);

		}

		

    	$core->SetSiteInfo(1,"min_deposit_value",(float)$data->min_deposit_value);

    	$core->SetSiteInfo(1,"max_deposit_value",(float)$data->max_deposit_value);

		

		

		$core->LogTrack($core_accid,"updated site settings");

		$core->redirect_to($core->domain . "dashboard/site-settings/err/m401/");	

		exit();

			

	}elseif($cmd=="editniche"){



		$shortname = $data->short_name;

		$contents = $data->contents;

		$done = $core->UpdateNiche($shortname,$contents);



		$core->LogTrack($core_accid,"updated site niche for {$shortname}");

		$core->redirect_to($core->domain . "dashboard/editniche/pid/{$shortname}/err/m401/");	

		exit();

		

	}elseif($cmd=="bugs"){

		

		$accid = $core->accid;

		

		if( isset($data->bugid) ){

			$bugid = intval($data->bugid);

			$bugfix = $data->bugfix;

			

			$BugInfo = $core->BugInfo($bugid);

			$core->FixBug($bugid,$bugfix);

			

			$BugDate = date("jS M Y g:i:a",strtotime($BugInfo->created));

			$BugDef = "Bug [{$bugid}] of {$BugDate}";

				

			$pUser = $core->UserInfo($BugInfo->accid);

			$Profile_Name = "{$pUser->nickname}";

			$subject = "BugFix [BUG#{$bugid}]";

			$html = sprintf($_lan['MAIL']['BUG_FIXED'],$Profile_Name,$BugDef,$BugInfo->bug,$bugfix);

			

			$core->NoReply($pUser->email,$Profile_Name,$subject,$html);

			$core->redirect_to($core->domain . "dashboard/bugs/err/m401/");	

			exit();

		}



		$bug = $data->bug;

		$done = $core->CreateBug($accid,$bug);

		$core->LogTrack($core_accid,"created bug - {$bug}");

		$core->redirect_to($core->domain . "dashboard/bugs/err/m401/");	

		exit();

				

	}elseif($cmd=="orderph"){

		

		$accid = $core->accid;

		$phamount = (float)$data->phamount;

		

		$min_deposit_value = $core->LastGHOrders($core->accid);

				

		if( $phamount < $min_deposit_value ){

			$core->redirect_to($core->domain . "dashboard/orderph/err/e913/");	

			exit();

		}

		

		if($phamount > $SiteInfo->max_deposit_value){

			$core->redirect_to($core->domain . "dashboard/orderph/err/e914/");	

			exit();

		}

		

		$Cummulative_PH_Value = $core->CummulativePHValue($core->accid);

		$Cummulatable = ($Cummulative_PH_Value + $phamount);

		if( $Cummulatable > $SiteInfo->cummulative_max_ph){

			$core->redirect_to($core->domain . "dashboard/orderph/err/e915/");	

			exit();

		}

		

		$orderid = $core->CreatePhOrder($accid,$phamount);

		if($orderid){

			$session->data['orderid'] = $orderid;

			$session->save();

			$core->redirect_to($core->domain . "dashboard/confirmph/");	

			exit();

		}

		

		$core->LogTrack($core_accid,"ordered PH");

		$core->redirect_to($core->domain . "dashboard/orderph/err/e402/");	

		exit();

				

				

	}elseif($cmd=="alertify"){

		$accid = $core->accid;
		$matchid = $data->matchid;
		$paymode = $data->paymode;
		$session->data['matchid'] = $matchid;
		$session->data['paymode'] = $paymode;
		$session->save();
		$core->LogTrack($core_accid,"started payment");
		$core->redirect_to($core->domain . "dashboard/checkout/{$matchid}/");



	}elseif($cmd=="confirm-payment"){

		$accid = $core->accid;
		$matchid = $data->matchid;
		$payid = $data->payid;
		
		$ThisMatch = $core->GetMatch($matchid);
		$ThisPayment = $core->GetMatchedPayment($matchid);

		$transid = $ThisPayment->transid;
		$ThisOrder = $core->GetOrder($transid);

		$core->UpdateMatch($matchid,"status","completed");
		$core->UpdateMatch($matchid,"date_completed",date('Y-m-d H:i:s a'));
		$core->UpdatePayment($payid,"status","confirmed");
		
		if($ThisOrder->insured){
		
			if($ThisMatch->route=="donor"){
				
				$donid = $ThisMatch->donid;
				$core->UpdateOrder($transid,"status","completed");
				$core->UpdateOrder($transid,"completed",time());
				$core->UpdateOrder($transid,"mode","ex");
				$core->UpdateOrder($transid,"onmatch",0);
				
				$core->UpdateDonor($donid,"status","completed");
			
			}elseif($ThisMatch->route=="bulkdonor"){
				
			}else{
								
			}
			
		}else{
			
			$pay_period = $SiteInfo->pay_period;
			$timestarted = date('Y-m-d H:i:s a');
			$timeends = date('Y-m-d H:i:s a',strtotime("+{$pay_period} days"));
			$core->UpdateOrder($transid,"status","running");
			$core->UpdateOrder($transid,"started",$timestarted);
			$core->UpdateOrder($transid,"ends",$timeends);

		}

		$core->Trusteer($ThisPayment->accid, 5);
		$core->LogTrack($core_accid,"comfirmed payment");
		$core->redirect_to($core->domain . "dashboard/matchinfo/{$matchid}/err/m401/");

	}elseif($cmd=="checkout"){
		
		$accid = $core->accid;
		$matchid = $data->matchid;
		$paymode = $data->paymode;
		$payinfo = $data->payinfo;
		$ThisMatch = $core->GetMatch($matchid);
		$transid = $ThisMatch->transid_ph;
		$accid_gh = $ThisMatch->gh;
		$photo = "";
		
		if( isset($_FILES['pop']["name"]) ){
			$photo_path = "./Uploads/";
			$p_upnm	=  basename($_FILES["pop"]["tmp_name"]);
			$p_name = basename($_FILES['pop']['name']);
			$p_type	= $_FILES["pop"]["type"];
			$p_size = $_FILES['pop']['size'];
			$p_error = $_FILES['pop']['error'];
			$tsp = time();
			$fileguid = sha1( $tsp . $p_upnm . $p_name . $p_size );
			$ext = end( (explode(".", $p_name)) );
			$arr_types = array("image/jpeg","image/png","image/gif");
			if(!in_array($p_type,$arr_types)){
				$core->redirect_to($core->domain . "dashboard/checkout/{$matchid}/err/m401/");
			}
			if(!is_dir($photo_path)) {
				$mkdir = mkdir($photo_path,'0777',true);
			}
			
			//Do it//
			$to_file = sprintf("%s.%s",$fileguid,$ext);
			$to_path = "{$photo_path}{$to_file}";
			$db_to_path = $core->domain . ltrim($to_path,"./");
			$dlu = move_uploaded_file($_FILES['pop']['tmp_name'],$to_path);	
			//Do it//
			if($dlu){
				$photo = $db_to_path;
				$payit = $core->CreatePayment($accid,$transid,$matchid,$ThisMatch->amount,$paymode,$payinfo,$photo);
				if($payit){
					$payerUser = $core->UserInfo($accid);
					$payerProfile_Name = "{$pUser->nickname}";
					$paidAmount = $core->toNGN($ThisMatch->amount);
					$pUser = $core->UserInfo($accid_gh);
					$Profile_Name = "{$pUser->nickname}";
					$subject = "Payment Submitted [GH#{$ThisMatch->transid_gh}]";
					$html = sprintf($_lan['MAIL']['NEW_GH_PAYMENT'],$Profile_Name,$payerProfile_Name,$paidAmount);
					$core->NoReply($pUser->email,$Profile_Name,$subject,$html);
					$core->redirect_to($core->domain . "dashboard/matchinfo/{$ThisMatch->id}/");	
					exit();
				}
			}
			
			$session->data['matchid'] = $matchid;
			$session->data['paymode'] = $paymode;
			$session->save();
			$core->LogTrack($core_accid,"uploaded payment proof");
			$core->redirect_to($core->domain . "dashboard/checkout/{$ThisMatch->id}/");	
			exit();
		}
		
	}elseif($cmd=="withdraw-gh"){
		$accid = $core->accid;
		$transid = $data->transid;
		$ThisOrder = $core->GetOrder($transid);
		$WID = $core->RequestWithdrawal($ThisOrder->accid,$transid,$ThisOrder->payout);
		if($WID){
			
			$core->UpdateOrder($transid,"status","matching");
			$core->UpdateOrder($transid,"mode","gh");
			$core->UpdateOrder($transid,"onmatch",1);
			$core->UpdateOrder($transid,"date_withdrawal_started",date('Y-m-d H:i:s a'));
			
			$pUser = $core->UserInfo($ThisOrder->accid);
			$Profile_Name = "{$pUser->nickname}";
			$subject = "Withdrawal Requested [GH#{$transid}]";
			$html = sprintf($_lan['MAIL']['NEW_GH_WITHDRAWAL'],$Profile_Name);
			$core->NoReply($pUser->email,$Profile_Name,$subject,$html);
			$core->redirect_to($core->domain . "dashboard/withdrawals/err/m401/");	
			exit();
			
		}
		$core->LogTrack($core_accid,"started a withdrawal");
		$core->redirect_to($core->domain . "dashboard/withdraw-gh/{$transid}/err/e402");	
		exit();

	}elseif($cmd=="flagpayment"){

		

		$accid = $core->accid;

		

		$payid = $data->payid;

		$matchid = $data->matchid;

		$flagoption = $data->flagoption;

		$flaginfo = $data->flaginfo;

		

		$ThisMatch = $core->GetMatch($matchid);

		$transid = $ThisMatch->transid_ph;

		

		$accid_ph = $ThisMatch->ph;

		$accid_gh = $ThisMatch->gh;

		$amount = $ThisMatch->amount;

		

		

		$created = $core->FlagPayment($payid,$matchid,$accid_gh,$accid_ph,$amount,$flagoption,$flaginfo);

		

		if($created){



			$pUser = $core->UserInfo(1);

			$Profile_Name = "{$pUser->nickname}";

			$subject = "Your Payment is flagged [PH#{$transid}]";

			$html = sprintf($_lan['MAIL']['FLAG_PAYMENT'],$Profile_Name,$transid);

			$core->NoReply($pUser->email,$Profile_Name,$subject,$html);

			

			$core->redirect_to($core->domain . "dashboard/err/m403/");	

			exit();



		}else{

			$core->redirect_to($core->domain . "dashboard/err/e404/");	

			exit();

		}

		

		

	}elseif($cmd=="confirmph"){

		

		

		$accid = $core->accid;

		$orderid = $data->orderid;

		$ThisOrder = $core->GetOrder($orderid);

		

		$done = $core->RegisterPhOrder($orderid);

		if($done){

			

			$session->data['orderid'] = NULL;

			$session->save();

			$order_amount = $ThisOrder->amount;



			$pUser = $core->UserInfo($accid);

			$Profile_Name = "{$pUser->nickname}";

			$subject = "New PH Order [PH#{$ThisOrder->transid}]";

			$html = sprintf($_lan['MAIL']['NEW_PH_ORDER'],$Profile_Name,$order_amount);

			$core->NoReply($pUser->email,$Profile_Name,$subject,$html);

			

			$core->redirect_to($core->domain . "dashboard/orderinfo/{$ThisOrder->transid}/");	

			exit();

						

		}

		

		$core->LogTrack($core_accid,"comfirmed PH order");

		$core->redirect_to($core->domain . "dashboard/confirmph/err/e912/");	

		exit();		

	

	

	}elseif($cmd=="userinfo"){
		$accid = $core->accid;		
		$useraccid = $data->useraccid;
		if(isset($data->user_lockdown)){
			$user_lockdown = $data->user_lockdown;
			if($user_lockdown=="unblock"){
				if($core->UpdateDefault($useraccid,"status","cleared")){

					$ThisDefault = $core->GetDefault($useraccid);
					$matchid = $ThisDefault->matchid;
					$core->UpdateMatch($matchid,"status","failed");

					//$core->ClaimReferralBonuses($accid,true);
					
					$pUser = $core->UserInfo($useraccid);
					$Profile_Name = "{$pUser->nickname}";
					$subject = "Congrats! Account Unlocked";
					$html = sprintf($_lan['MAIL']['ACCOUNT_LOCKDOWN_REMOVED'],$Profile_Name);
					$core->NoReply($pUser->email,$Profile_Name,$subject,$html);
					$core->LogTrack($core_accid,"cleared clock status of user {$core->TraceAccid($useraccid)}");
				}
			}elseif($user_lockdown=="reverse"){
				if($core->UpdateDefault($useraccid,"status","reversed")){
					$ThisDefault = $core->GetDefault($useraccid);
					$trusteer = $core->Trusteer($accid,$ThisDefault->trustpoint);
					if($trusteer){
						$transid = $ThisDefault->transid;
						$ph_completed = $core->PHcompleted($transid);
						$paid_up = $ph_completed >= $amount;
						if($PHo->insured && !$paid_up){
							if($PHo->status!="running"){
								$core->UpdateOrder($transid,"status","running");
							}
						}elseif($PHo->insured && $paid_up){
							if($PHo->status!="running"){
								$core->UpdateOrder($transid,"status","running");
								$core->UpdateOrder($transid,"mode","gh");
							}
						}

					}
					$pUser = $core->UserInfo($useraccid);
					$Profile_Name = "{$pUser->nickname}";
					$subject = "Congrats! Penalty Reversed";
					$html = sprintf($_lan['MAIL']['ACCOUNT_LOCKDOWN_REVERSED'],$Profile_Name);
					$core->NoReply($pUser->email,$Profile_Name,$subject,$html);
					$core->LogTrack($core_accid,"reversed clock status of user{$core->TraceAccid($useraccid)}");
				}

			}

		}

		

		if(isset($data->user_verify)){

			$core->SetVerify($useraccid,"mobile_verified",1);

			$core->SetVerify($useraccid,"verified",1);

			$core->Trusteer($useraccid,25);	



			$core->LogTrack($core_accid,"manually verified user {$core->TraceAccid($useraccid)}");

			

		}

		

		if(isset($data->user_unverify)){

			$core->SetVerify($useraccid,"mobile_verified",0);

			$core->SetVerify($useraccid,"verified",0);

			$core->UnTrusteer($useraccid,25);	

			$core->LogTrack($core_accid,"manually un-verified user {$core->TraceAccid($useraccid)}");

		}

		



		if(isset($data->make_collector)){
			//Pull all PH orders//
			$PHOrders = $core->MyPHOrders($useraccid);
			$CountPH = (int)mysql_num_rows($PHOrders);
			if($CountPH){
				while($phorder=mysql_fetch_object($PHOrders)){
					$core->UpdateOrder($phorder->id,"status","matching");	
					$core->UpdateOrder($phorder->id,"mode","gh");	
					$core->UpdateOrder($phorder->id,"started",date("Y-m-d g:i:s"));	
				}
				$core->UpdateUser($useraccid,"iscollector",1);
				$core->LogTrack($core_accid,"just made the user {$core->TraceAccid($useraccid)} a collector account");
			}else{
				$core->LogTrack($core_accid,"could not make user {$core->TraceAccid($useraccid)} a collector, no PH Order found");
			}

		}

		

		

		if(isset($data->remove_collector)){

			//Pull all PH orders//

			$GHOrders = $core->MyWithdrawals($useraccid);

			$CountPH = (int)mysql_num_rows($GHOrders);

			if($CountPH){

				while($ghorder=mysql_fetch_object($GHOrders)){

					$core->UpdateOrder($ghorder->id,"status","completed");	

					$core->UpdateOrder($ghorder->id,"mode","ex");	

					$core->UpdateOrder($ghorder->id,"completed",time());

				}

				$core->UpdateUser($useraccid,"iscollector",0);

				$core->LogTrack($core_accid,"just removed the user {$core->TraceAccid($useraccid)} as a collector account");

			}else{

				$core->LogTrack($core_accid,"could not remove user {$core->TraceAccid($useraccid)} a collector, no Withdrawal request found");

			}

		}

		

		if(isset($data->user_disable)){

			if($core->UpdateUser($useraccid,"enabled",0)){

				$pUser = $core->UserInfo($useraccid);

				$Profile_Name = "{$pUser->nickname}";

				$subject = "Pity! Account Disabled";

				$html = sprintf($_lan['MAIL']['ACCOUNT_DISABLED'],$Profile_Name);

				$core->NoReply($pUser->email,$Profile_Name,$subject,$html);

				$core->LogTrack($core_accid,"disabled user {$core->TraceAccid($useraccid)}");

			}

		}



		if(isset($data->user_enable)){

			if($core->UpdateUser($useraccid,"enabled",1)){

				$pUser = $core->UserInfo($useraccid);

				$Profile_Name = "{$pUser->nickname}";

				$subject = "Congrats! Account Enabled";

				$html = sprintf($_lan['MAIL']['ACCOUNT_ENABLED'],$Profile_Name);

				$core->NoReply($pUser->email,$Profile_Name,$subject,$html);

				$core->LogTrack($core_accid,"ensabled user {$core->TraceAccid($useraccid)}");

			}

		}



		$core->redirect_to($core->domain . "dashboard/userinfo/{$useraccid}/err/m401/");	

		exit();		

	

	

	

	}elseif($cmd=="newpage"){

		

		$shortname = $data->shortname;

		$parent = $data->parent;

		$title = $data->title;

		$menutitle = $data->menutitle;

		$sort = $data->sort;

		$isnews = $data->isnews;

    	$contents = $data->contents;

			

		$done = $core->CreatePage($parent,$menutitle,$title,$contents,$sort,$shortname,$isnews);

		if($done){

			$core->LogTrack($core_accid,"created a new page");

			$core->redirect_to($core->domain . "dashboard/editpage/pid/{$shortname}/");	

			exit();		

		}else{

			$core->redirect_to($core->domain . "dashboard/newpage/");	

			exit();		

		}

		

	}elseif($cmd=="editpage"){

		

		

		$xpid = $data->short_name;

	

		$shortname = $data->shortname;

		$parent = $data->parent;

		$title = $data->title;

		$menutitle = $data->menutitle;

		$sort = $data->sort;

		$isnews = $data->isnews;

    	$contents = $data->contents;

			

		$done = $core->UpdatePage($xpid,$parent,$menutitle,$title,$contents,$sort,$shortname,$isnews);

		

		$track = $core->LogTrack($core_accid,"edited page - {$shortname}");	

		

		$core->redirect_to($core->domain . "dashboard/editpage/pid/{$shortname}/");	

		exit();

		

	}elseif($cmd=="cancel-phorder"){

	

		$accid = $core->accid;

		$transid = $data->transid;

		$ThisOrder = $core->GetOrder($transid);

		

		$done = $core->DeletePhOrder($transid);

				

		if($done){

			

			$core->RemoveBonus($transid);

			

			$core->UnTrusteer($accid,5);	

			$Profile_Name = "{$pUser->nickname}";

			$subject = "PH Order [PH#{$ThisOrder->transid}] | Deleted!";

			$html = sprintf($_lan['MAIL']['DELETED_PH_ORDER'],$Profile_Name);

			$core->NoReply($pUser->email,$Profile_Name,$subject,$html);

			$core->LogTrack($core_accid,"cancelled order: {$ThisOrder->transid}");

			$core->redirect_to($core->domain . "dashboard/phorders/err/m401/");	

			exit();

		}

		

		$core->redirect_to($core->domain . "dashboard/phorders/err/e402/");	

		exit();		

		

		

	}



	

endif;

ob_end_flush();

?>