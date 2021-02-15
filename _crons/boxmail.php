<?php


	$Pending = $core->LoadACampaign("pending");
	$has_campaign = mysql_num_rows($Pending);
	
	if($has_campaign){
	
		$ThisCampaign = mysql_fetch_object($Pending);
		if(!$ThisCampaign->loaded){
			
			$CID = $ThisCampaign->id;
			$GID = $ThisCampaign->gid;
			$MID = $ThisCampaign->mid;
			
			$ThisMail = $core->MailInfo($MID);
			$ThisGroup = $core->GroupInfo($GID); 
			$ThisList = $core->AllLists($GID);

			$cpanelresult = $cpanel->api2_query(
				$core->cpanel_user, 'Cron', 'add_line',
					array(
					'command' => "php -q /home/interpix/public_html/cron.php cron=sendmail cid={$CID}",
					'day'	=> '*',
					'hour'	=> '*',
					'minute'	=> '*',
					'month'	=> '*',
					'weekday'	=> '*',
				)
			);
			
			$cpanelresult =  json_decode($cpanelresult);
			$cpanelresult =  $cpanelresult->cpanelresult;
			$data =  $cpanelresult->data[0];
			$status =  $data->status;
			$linekey =  $data->linekey;
			if($status){
				$ListToJson = $core->ListToJson($GID);
				$xcron = $core->toCron($CID,$linekey,$ListToJson);				
				$core->UpdateCampaign($CID,"loaded",1);
				$core->UpdateCampaign($CID,"status","sending");
			}
			
		}
	}