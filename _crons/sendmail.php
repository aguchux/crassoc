<?php
	
	$cid = $data->cid;
	
	$CampaignInfo = $core->CampaignInfo($cid);
	$ThisGroup = $core->GroupInfo($CampaignInfo->gid); 
	$ThisMail = $core->MailInfo($CampaignInfo->mid);
	$ThisCron = $core->CronInfo($cid);
	
	$j = $CampaignInfo->epm;
	$Leads = json_decode($ThisCron->list, true);
	$Leads = array_values($Leads);
	$LeadsLeft = count($Leads);
	if($LeadsLeft){
		//if mail is not exhausted//
		$sent = false;
		$i = 0;
		foreach($Leads as $key=>$val){
			$i++;
			try{
				$NamePart = explode("@",$val);
				$NamePart = ucfirst($NamePart[0]);
				
				$PHPmailer = new PHPMailer(true);
				$PHPmailer->CharSet = "text/html; charset=UTF-8;";
				$PHPmailer->isHTML(true);
				$PHPmailer->setFrom( $ThisMail->fromemail,$ThisMail->fromname );
				$PHPmailer->AddReplyTo( $ThisMail->replyemail,$ThisMail->replyname );
				$PHPmailer->Subject = $ThisMail->title;
				
				$PHPmailer->AddAddress($val,$NamePart);
				
				$PHPmailer->MsgHTML($ThisMail->content);
				$PHPmailer->IsMail();
				$sent = $PHPmailer->Send();			
				
				if($sent){
					//Remove email & Update Leads//
					unset($Leads[$key]);
					$Leads = array_values($Leads);
					$Leads = json_encode($Leads);
					$core->UpdateCron($ThisCron->id,"list",$Leads);
					$core->UpdateCron($ThisCron->id,"lastsent",date('Y-m-d H:i:s'));
					//Remove email & Update Leads//
				}
					
			}catch(phpmailerException $e){
				//echo $sent;
			}catch (Exception $e) {
				//echo $sent;
			}

			if($i==$j){break;}
		}
		//if mail is not exhausted//
	
	}else{
		
		
		//Delete Cron//
		$cpanelresult = $cpanel->api2_query(
			$core->cpanel_user, 'Cron', 'listcron'
		);
		$cpanelresult =  json_decode($cpanelresult);
		$cpanelresult =  $cpanelresult->cpanelresult;
		$data =  $cpanelresult->data;
		foreach($data as $key=>$cron){
			$comm = $cron->command;
			if($comm=="php -q /home/interpix/public_html/cron.php cron=sendmail cid={$cid}"){
				$line = $cron->count;
				$cpanelresult = $cpanel->api2_query(
					$core->cpanel_user, "Cron", "remove_line",
					array(
						"line"=>$line
					)
				);
			}
		}
		$core->UpdateCampaign($cid,"status","completed");
		//Delete Cron//
		
		
	}
	
