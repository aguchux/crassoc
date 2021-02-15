<?php

class core{
	
	public $debug = DEBUG;
	public $site = NULL;
	public $public_path;
	public $use_token_security = use_token_security;
	public $username = "";
	public $UserInfo = NULL;
	public $SiteInfo = NULL;
	public $appid = appid;
	public $appname = appname;
	public $accid = 0;
	public $encrypt_salt = encrypt_salt;
	public $isLoggedIn = false;
	public $domain = domain;
	public $dashboard = dashboard;
	public $location = "en";
	public $use_smtp = use_smtp;


	private $key_array = array();
	private $data_array = array();
	private $form_posted_array = array();
	public $returned_posted_array = array();

	public $cpanel_host = cpanel_host;
	public $cpanel_user = cpanel_user;
	public $cpanel_pass = cpanel_pass;

	//Database Settings
	public $host = host;
	public $user = user;
	public $password = password;
	public $db = db;
	//date and time setting
	public $default_timezone = default_timezone;
	public $today = '';
	//Site Class variables
	public $dbCon = NULL;
	public $dbSel = "";
    public $breadcrumb = 'Home';	
	public $mail_ping_batch_qty = mail_ping_batch_qty;

	public function __construct(){
		if (!$this->dbCon = mysqli_connect($this->host, $this->user,$this->password,$this->db)) {
      		exit('Error: Could not make a database connection using ' . $this->user . '@' . $this->host);
    	}

 		mysqli_query($this->dbCon,"SET NAMES 'utf8'");
		mysqli_query($this->dbCon,"SET CHARACTER SET utf8");
		mysqli_query($this->dbCon,"SET CHARACTER_SET_CONNECTION nnm=utf8");
		mysqli_query($this->dbCon,"SET SQL_MODE = ''");
		//Set default time zone
		date_default_timezone_set($this->default_timezone);
		$this->setReporting();
		$this->removeMagicQuotes();
		$this->unregisterGlobals();
		$this->public_path = "./_config/";
  	}

	
	public function debug($data) {
		print_r($data);
		exit();
	}

	public function GenerateToken($frm) {
		$token = $this->Passwordify($frm);
		return $token;
	}

		
	/** Check if environment is development and display errors **/
	public function setReporting() {
		if ($this->debug == true) {
			error_reporting(E_ALL);
			ini_set('display_errors',"On");
		}else{
			error_reporting(E_ALL);
			ini_set('display_errors',"Off");
			ini_set('log_errors', "On");
			ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
		} 
	}


	/** Check for Magic Quotes and remove them **/
	public function removeMagicQuotes() {
		if ( get_magic_quotes_gpc() ) {
			$_GET = stripSlashesDeep($_GET   );
			$_POST = stripSlashesDeep($_POST  );
			$_COOKIE = stripSlashesDeep($_COOKIE);
		}
	}

	/** Check register globals and remove them **/
	public function unregisterGlobals() {
		if (ini_get('register_globals')) {
			$array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
			foreach ($array as $value) {
				foreach ($GLOBALS[$value] as $key => $var) {
					if ($var === $GLOBALS[$key]) {
						unset($GLOBALS[$key]);
					}
				}
			}
		}
	}


	public function stripSlashesDeep($value) {
		$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
		return $value;
	}

	public function inTime($start,$end){
		$start_date = new DateTime($start);
		$end_date = new DateTime($end);
		$since_start = $start_date->diff($end_date);
		return $since_start;
	}

	public function inSeconds($start,$end){
		$start_date = new DateTime($start);
		$end_date = new DateTime($end);
		$since_start = $start_date->diff($end_date);
		$diff = $since_start->days * 24 * 60 * 60;
		$diff += $since_start->h * 60 * 60;
		$diff += $since_start->i * 60;
		$diff += $since_start->s;
		if($since_start->invert){
			return 0;
		}else{
			return $diff;
		}
	}


	public function inMinutes($start,$end){
		$start_date = new DateTime($start);
		$end_date = new DateTime($end);
		$since_start = $start_date->diff($end_date);
		$diff = $since_start->days * 24 * 60;
		$diff += $since_start->h * 60;
		$diff += $since_start->i;
		return $diff;
		if($since_start->invert){
			return 0;
		}else{
			return $diff;
		}
	}

	

	public function inHours($start,$end){
		$start_date = new DateTime($start);
		$end_date = new DateTime($end);
		$since_start = $start_date->diff($end_date);
		$diff = $since_start->days * 24;
		$diff += $since_start->h;
		return $diff;
		if($since_start->invert){
			return 0;
		}else{
			return $diff;
		}
	}

	

	public function inDays($start,$end){
		$start_date = new DateTime($start);
		$end_date = new DateTime($end);
		$since_start = $start_date->diff($end_date);
		$diff = $since_start->days;
		return $diff;
		if($since_start->invert){
			return 0;
		}else{
			return $diff;
		}

	}



	public function post($posted_array){
		$this->form_posted_array = $posted_array;
		$forms = new stdClass();		
		if(is_array($posted_array)){
			foreach($posted_array as $key =>$val){
				if(is_array($val)){
					$this->returned_posted_array[$key] = $val ;
					$forms->$key = $val ;
				}else{
					$this->returned_posted_array[$key] = $this->mysql_prepare_value( $val );
					$forms->$key = $this->mysql_prepare_value( $val );
				}
			}
			return $forms;
		} else {
      		exit('Error: Form not good');
    	}
  	}
	public function mysql_prepare_value($value) {
		//check if get_magic_quotes_gpc is turned on.
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_version_php = function_exists("mysqli_real_escape_string");
		
		if($new_version_php){
			//undo any magic quote effects so mysql_real_escape_string can do the work
			if($magic_quotes_active) { $value = stripslashes($value); }
			$value = mysqli_real_escape_string($this->dbCon,$value);
		} else {
				//if magic quotes aren't already on then add slashes manually
				if( !$magic_quotes_active ) { $values = addslashes( $value ); }
				//if magic quotes are active, then the slashes already exist
			}
		return $value;
	}


	public function escape($value) {
		return real_escape_string($value);
	}

  	public function countAffected() {
    	return mysqli_affected_rows($this->dbCon);
  	}

  	public function getLastId() {
    	return mysqli_insert_id($this->dbCon);
  	}


	public function url_to_domain($url){
		$pieces = parse_url($url);
		$domain = isset($pieces['host']) ? $pieces['host'] : '';
		if(preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)){
			return htmlspecialchars($regs['domain']);
		}
		return FALSE;
	}	

	public function ThisURL(){
		$pieces = "http://";
		$host = $_SERVER['HTTP_HOST'];
		$uri = $_SERVER['REQUEST_URI'];
		$pieces .= $host . $uri;
		return $pieces;
	}	

	public function Passwordify($password){
		$fpw = sha1( $this->enSaltIt(md5($password)) );
		return $fpw;
	}

	public function ProtectedPage(){
		if(!$this->isLoggedIn){
			$this->redirect_to($this->domain . "team/signin/");
			exit();
		}
	}

	public function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return real_escape_string($str);
	}

	
	public function redirect_to($location = NULL) {
		header("location: {$location}");
		exit();
	}
	
  	public function DoxLogin($email,$password){
		$DoxLogin = mysqli_query($this->dbCon,"select * from dox_login where email='$email' AND password='$password'");
		$DoxLogin = mysqli_fetch_assoc($DoxLogin);
		return $DoxLogin;
  	}
  
  	public function UserInfo($accid){
		$UserInfo = mysqli_query($this->dbCon,"select * from dox_login where accid='$accid'");
		$UserInfo = mysqli_fetch_object($UserInfo);
		return $UserInfo;
  	}
  
  
  
  
  
  
  
  
  
  
  
  
  
  

	public function SecureForm($caption="Update Changes",$disabled=false){
		$d_class = $disabled==true?"disabled='disabled'":"";
		$htm = "";
		$htm .= "<div class=\"form-buttons-w\">";
		$htm .= "<button {$d_class} class=\"btn btn-primary btn-block\" type=\"submit\">{$caption}</button>";
		$htm .= "</div>";
		return $htm;
	}
  
  
  
	public function Banned($domain){
		$Banned = mysqli_query($this->dbCon,"SELECT id FROM dox_banned_domains WHERE domain='$domain'");
		return $this->countAffected();
  	}
  
	public function BanDomain($domain){
		$BanDomain = mysqli_query($this->dbCon,"SELECT domain FROM dox_banned_domains WHERE domain='$domain'");
		if(!$this->countAffected()){
			mysqli_query($this->dbCon,"insert into dox_banned_domains(domain) values('$domain')");
			return $this->getLastId();
		}
		return false;
	}
	
	
	public function BanMe($me,$mid){
		$BanDomain = mysqli_query($this->dbCon,"SELECT email FROM dox_banned WHERE email='$me'");
		if(!$this->countAffected()){
			mysqli_query($this->dbCon,"insert into dox_banned(email,mid) values('$me','$mid')");
			return $this->getLastId();
		}
		return false;
	}
	
	public function IsBanned($email){
		$Banned = mysqli_query($this->dbCon,"SELECT banid FROM dox_banned WHERE email='$email'");
		return $this->countAffected();
  	}

	public function GenUserId(){
	  $GenUserId = mysqli_query($this->dbCon,"select accid from gnet_accounts");
	  $CN = mysqli_num_rows($GenUserId);
	  return userid_refix_number . ($CN + 1);
 	}

	public function CreatAccount($email,$password){
		$CreatAccount = mysqli_query($this->dbCon,"insert into dox_login(email,password) values('$email','$password')");
		return $this->getLastId();
	}
	
	public function UpdateAccount($accid,$key,$val) {
		$UpdateAccount = mysqli_query($this->dbCon,"UPDATE dox_login set $key='$val' WHERE accid='{$accid}'");
		return $this->countAffected();
	}
	
		
	public function GenPassword($length=10) {
		$characters = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}



  public function SetSiteInfo($appid,$d_key,$d_val){
	  $SetSiteInfo = mysqli_query($this->dbCon,"UPDATE siteinfo SET {$d_key}='{$d_val}' where appid='$appid'");
	  return $this->countAffected();
  }

	
	public function CreateGroup($accid,$groupname){
		$CreateGroup = mysqli_query($this->dbCon,"insert into dox_groups(accid,name) values('$accid','$groupname')");
		return $this->getLastId();
	}
	
  	public function GroupInfo($gid){
		$GroupInfo = mysqli_query($this->dbCon,"select * from dox_groups where id='$gid'");
		$GroupInfo = mysqli_fetch_object($GroupInfo);
		return $GroupInfo;
  	}

	public function ListGroups($accid){
		$ListGroups = mysqli_query($this->dbCon,"select * from dox_groups where accid='$accid'");
		return $ListGroups;
  	}
  
	public function CountList($gid){
		$Qry = mysqli_query($this->dbCon,"SELECT SUM(emailcount) AS qty FROM dox_lists WHERE gid='$gid'");
		$Qry = mysqli_fetch_object($Qry);
		return $Qry->qty;
  	}
  
	public function InList($gid,$email){
		$InList = mysqli_query($this->dbCon,"SELECT id FROM dox_lists WHERE email='$email' AND gid='$gid'");
		return $this->countAffected();
  	}

  	public function ListInfo($gid){
		$ListInfo = mysqli_query($this->dbCon,"select * from dox_lists where gid='$gid'");
		$ListInfo = mysqli_fetch_object($ListInfo);
		return $ListInfo;
  	}
	public function UpdateList($id,$key,$val) {
		$UpdateList = mysqli_query($this->dbCon,"UPDATE dox_lists set $key='$val' WHERE id='{$id}'");
		return $this->countAffected();
	}
	
	public function UpdateListByGid($gid,$key,$val) {
		$UpdateListByGid = mysqli_query($this->dbCon,"UPDATE dox_lists set $key='$val' WHERE gid='{$gid}'");
		return $this->countAffected();
	}
	
	public function UpdateGroup($id,$key,$val) {
		$UpdateGroup = mysqli_query($this->dbCon,"UPDATE dox_groups set $key='$val' WHERE id='{$id}'");
		return $this->countAffected();
	}
	
	public function AllLists($gid){
		$AllLists = mysqli_query($this->dbCon,"select * from dox_lists where gid='$gid'");
		return $AllLists;
  	}
	public function GetGIDList($gid){
		$GetGIDList = mysqli_query($this->dbCon,"select email from dox_lists where gid='$gid' LIMIT 1");
		$GetGIDList = mysqli_fetch_object($GetGIDList);
		return $GetGIDList->email;
  	}
  
	public function ListToJson($gid){
		$lst = "";
		$ListToJson = mysqli_query($this->dbCon,"SELECT email FROM dox_lists where gid='$gid'");
		$mlist = array();
		while($list=mysqli_fetch_object($ListToJson)){
			$decson = json_decode($list->email);
			$mlist = array_merge($decson,$mlist);
		}
		return json_encode($mlist);
  	}
  
	public function AddMail($gid,$email,$domain){
		if( !$this->InList($gid,$email) ){
			$AddMail = mysqli_query($this->dbCon,"insert into dox_lists(gid,email,domain) values('$gid','$email','$domain')");
			return $this->getLastId();
		}
		return false;
	}

	public function AddToList($gid,$list,$emailcount){
		$AddToList = mysqli_query($this->dbCon,"insert into dox_lists(gid,email,emailcount) values('$gid','$list','$emailcount')");
		return $this->getLastId();
	}

	public function GetEmailDomain($email){
		$domain = explode("@",$email);
		$domain = $domain[1];
		return $domain;
	}

	public function IsValidEmail($email){
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return false;
		}else{
			return true;
		}
	}

	public function ComposeMail($accid,$title,$fromname,$fromemail,$replyname,$replyemail,$contents){
		$ComposeMail = mysqli_query($this->dbCon,"insert into dox_mails(accid,title,fromname,fromemail,replyname,replyemail,content) values('$accid','$title','$fromname','$fromemail','$replyname','$replyemail','$contents')");
		return $this->getLastId();
	}
	
	public function ListMails($accid){
		$ListMails = mysqli_query($this->dbCon,"select * from dox_mails where accid='$accid'");
		return $ListMails;
  	}
  
	
  	public function CronInfo($cid){
		$CronInfo = mysqli_query($this->dbCon,"select * from dox_oncron where cid='$cid'");
		$CronInfo = mysqli_fetch_object($CronInfo);
		return $CronInfo;
  	}
	
	public function toCron($cid,$linekey,$list){
		$toCron = mysqli_query($this->dbCon,"insert into dox_oncron(cid,cronkey,list) values('$cid','$linekey','$list')");
		return $this->getLastId();
	}
	

	public function SetupCampaign($accid,$campaign,$mid,$gid,$epm,$trottled,$treaded){
		$SetupCampaign = mysqli_query($this->dbCon,"insert into dox_campaigns(accid,campaign,mid,gid,epm,trottled,treaded) values('$accid','$campaign','$mid','$gid','$epm','$trottled','$treaded')");
		return $this->getLastId();
	}
 
  	public function CampaignInfo($cid){
		$CampaignInfo = mysqli_query($this->dbCon,"select * from dox_campaigns where id='$cid'");
		$CampaignInfo = mysqli_fetch_object($CampaignInfo);
		return $CampaignInfo;
  	}


  	public function CountExistingCampaign($cid){
		$CampaignInfo = mysqli_query($this->dbCon,"select id from dox_campaigns where id='$cid'");
		return $this->countAffected();
  	}


  	public function MailInfo($mid){
		$MailInfo = mysqli_query($this->dbCon,"select * from dox_mails where id='$mid'");
		$MailInfo = mysqli_fetch_object($MailInfo);
		return $MailInfo;
  	}
 
	public function ListCampaigns($accid){
		$ListCampaigns = mysqli_query($this->dbCon,"select * from dox_campaigns where accid='$accid' AND  status!='completed'");
		return $ListCampaigns;
  	}

	public function AllCampaigns($status='status'){
		$AllCampaigns = mysqli_query($this->dbCon,"select * from dox_campaigns where status='$status'");
		return $AllCampaigns;
  	}

	public function LoadACampaign($status){
		$LoadACampaign = mysqli_query($this->dbCon,"SELECT * FROM dox_campaigns WHERE status='$status' ORDER BY created DESC LIMIT 1");
		return $LoadACampaign;
  	}
	
	
	public function UpdateCampaign($id,$key,$val) {
		$UpdateCampaign = mysqli_query($this->dbCon,"UPDATE dox_campaigns set $key='$val' WHERE id='{$id}'");
		return $this->countAffected();
	}

	public function UpdateMail($id,$key,$val) {
		$UpdateMail = mysqli_query($this->dbCon,"UPDATE dox_mails set $key='$val' WHERE id='{$id}'");
		return $this->countAffected();
	}

	public function UpdateCron($id,$key,$val) {
		$UpdateCron = mysqli_query($this->dbCon,"UPDATE dox_oncron set $key='$val' WHERE id='{$id}'");
		return $this->countAffected();
	}


  	public function CountExistingCron($cid){
		$CampaignInfo = mysqli_query($this->dbCon,"select id from dox_oncron where cid='$cid'");
		return $this->countAffected();
  	}

	public function LoadSelectMails($accid){
		$htm = "<select class=\"form-control\" name=\"demail\" required>";
		$htm .= "<option value=\"\" selected=\"selected\">Select Email</option>";
		$LoadSelectMails = mysqli_query($this->dbCon,"select * from dox_mails where accid='$accid'");
		while($mail=mysqli_fetch_object($LoadSelectMails)){
			$htm .= "<option value=\"{$mail->id}\">{$mail->title}</option>";
		}
		$htm .= "</select>";
		return $htm;
  	}


	public function LoadSelectGroup($accid){
		$htm = "<select class=\"form-control\" name=\"group\" required>";
		$htm .= "<option value=\"\" selected=\"selected\">Select Group</option>";
		//$LoadSelectGroup = mysqli_query($this->dbCon,"select * from dox_groups where accid='$accid' AND verification='verified'");
		$LoadSelectGroup = mysqli_query($this->dbCon,"select * from dox_groups where accid='$accid'");
		while($group=mysqli_fetch_object($LoadSelectGroup)){
			$cnt = $this->CountList($group->id);
			$htm .= "<option value=\"{$group->id}\">{$group->name} ({$cnt})</option>";
		}
		$htm .= "</select>";
		return $htm;
  	}


// PHP Email //	
	public function Mailit($email,$name,$subject,$html){
		
		try{
			$PHPmailer = new PHPMailer(true);
			$PHPmailer->AddAddress($email,$name);
			
			$PHPmailer->setFrom( "sales@vetuweb.com","VetuWeb WHC" );
			$PHPmailer->AddReplyTo( "sales@vetuweb.com","VetuWeb WHC" );
			$PHPmailer->ReturnPath( "bounced@vetuweb.com","Bounced@VetuWeb" );
			
			$PHPmailer->Subject = $subject;
			
			$PHPmailer->DKIM_domain = 'vetuweb.com';
			$PHPmailer->DKIM_private = ROOT . "/etc/_DKIM/private.key";
			$PHPmailer->DKIM_selector = '1513355176.vetuweb';
			$PHPmailer->DKIM_passphrase = '';
			$PHPmailer->DKIM_identity = $PHPmailer->From;
			$PHPmailer->isHTML(true);
			
			$body = "{$html}";
			$PHPmailer->MsgHTML($body);
			
			$PHPmailer->Encoding = "base64";
			
			$sent = $PHPmailer->Send();
			return $sent;
			
		}catch(phpmailerException $e){
				return $sent;
		}catch (Exception $e) {
				return $sent;
		}
	}



	
  public function SiteInfo($appid){
	  $SiteInfo = mysqli_query($this->dbCon,"select * from siteinfo where appid='$appid' LIMIT 1");
	  $SiteInfo = mysqli_fetch_object($SiteInfo);
	  return $SiteInfo;
  }


//Set and Get Site Settions
	public function LoadOptions($loc='general') {
		$option = mysqli_query($this->dbCon,"SELECT * FROM gnet_options WHERE loc='$loc'");
		return $option;
	}
//Set and Get Site Settions

	public function GetOption($option_name) {
		$GetOption = mysqli_query($this->dbCon,"SELECT value FROM gnet_options WHERE name='{$option_name}'");
		$GetOption = mysqli_fetch_object($GetOption);
		return $GetOption->value;
	}
//Set and Get Site Settions

	public function SetOption($option_name,$option_value) {
		$SetOption = mysqli_query($this->dbCon,"UPDATE gnet_options set value='$option_value' WHERE name = '{$option_name}'");
		return $this->countAffected();
	}





//KILL OBJECT//	
	public function __destruct(){
		if(is_object($this->dbCon)){
			mysqli_close($this->dbCon);	
		}
	}
//KILL OBJECT//	

	

}	

	

?>